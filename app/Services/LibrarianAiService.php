<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LibrarianAiService
{
    /**
     * Dapatkan respon dari AI Pustakawan Readify
     */
    public function chat(string $userMessage, array $history = []): array
    {
        $userMessage = trim($userMessage);

        if (empty($userMessage)) {
            return [
                'reply' => "Halo! Ada yang bisa saya bantu seputar perpustakaan Readify? Silakan tanyakan rekomendasi buku, tata cara peminjaman, atau lokasi rak buku.",
                'books' => [],
            ];
        }

        // 1. Ekstrak buku-buku relevan dari database Readify (RAG)
        try {
            $relevantBooks = $this->findRelevantBooks($userMessage);
        } catch (\Throwable $e) {
            $relevantBooks = collect();
        }

        // 2. Jika GEMINI_API_KEY disetel di .env, gunakan Gemini API resmi
        $geminiKey = env('GEMINI_API_KEY');
        if (!empty($geminiKey)) {
            $geminiReply = $this->callGemini($userMessage, $history, $relevantBooks, $geminiKey);
            if (!empty($geminiReply)) {
                return $this->formatResult($geminiReply, $relevantBooks, $userMessage);
            }
        }

        // 3. Smart Instant Local Knowledge & RAG Engine (Zero Latency, <20ms)
        $reply = $this->localKnowledgeEngine($userMessage, $relevantBooks);

        return $this->formatResult($reply, $relevantBooks, $userMessage);
    }

    /**
     * Format output standar untuk frontend
     */
    protected function formatResult(string $reply, $relevantBooks, string $userMessage = ''): array
    {
        $q = strtolower($userMessage);
        $isRefusal = str_contains($reply, 'hanya dapat membantu pertanyaan seputar perpustakaan');
        
        // Cek apakah intent adalah info prosedural umum (salam, aturan, cara pinjam, denda, rak, usul buku, terima kasih)
        // di mana melampirkan kartu buku tidak relevan
        $isGeneralInfo = preg_match('/\b(halo|hai|hello|hi|p|tes|test|terima kasih|makasih|thanks|ok|oke|siap|aturan|denda|terlambat|cara pinjam|cara kembali|usul buku|siapa kamu)\b/i', $q)
            && !preg_match('/\b(rekomendasi|cari|buku apa|ada buku|novel|manga|komik|fiksi|teknologi|sains|bisnis|sejarah|biografi|filosofi)\b/i', $q);

        $shouldAttachBooks = !$isRefusal && !$isGeneralInfo && $relevantBooks->isNotEmpty();

        return [
            'status' => 'success',
            'reply' => $reply,
            'books' => $shouldAttachBooks ? $relevantBooks->map(function ($b) {
                return [
                    'id_buku' => $b->id_buku,
                    'judul_buku' => $b->judul_buku,
                    'penulis' => $b->penulis,
                    'stok' => $b->stok,
                    'lokasi_rak' => $b->lokasi_rak,
                    'sampul' => $b->sampul ? Storage::url($b->sampul) : null,
                ];
            })->values()->all() : [],
        ];
    }

    /**
     * Cari buku di database yang cocok dengan kata kunci pengguna (Exact + Partial + Category Match)
     */
    protected function findRelevantBooks(string $query)
    {
        $q = strtolower(trim($query));

        // 1. Cek Exact Phrase Matching terlebih dahulu (misal: "Clean Code", "One Piece", "Tatsuki Fujimoto")
        // Bersihkan tanda tanya / seru di akhir kalimat
        $cleanPhrase = trim(preg_replace('/[?!,.]/', '', $query));
        // Hilangkan kata awalan tanya jika ada
        $cleanPhrase = trim(preg_replace('/^(apakah ada buku|ada buku|buku|rekomendasi buku|cari buku)\s+/i', '', $cleanPhrase));

        if (strlen($cleanPhrase) >= 3) {
            $exactMatched = Buku::with('kategori')
                ->where('judul_buku', 'like', "%{$cleanPhrase}%")
                ->orWhere('penulis', 'like', "%{$cleanPhrase}%")
                ->take(5)
                ->get();

            if ($exactMatched->isNotEmpty()) {
                return $exactMatched;
            }
        }

        // 2. Keyword split search
        $keywords = preg_split('/\s+/', preg_replace('/[^a-zA-Z0-9\s]/', '', $cleanPhrase));
        $stopwords = [
            'ada', 'apa', 'apakah', 'buku', 'tentang', 'rekomendasi', 'yang', 'dan', 'di', 
            'ini', 'itu', 'saya', 'mau', 'cari', 'tolong', 'bisa', 'kah', 'bagus', 'seru', 
            'terbaik', 'halo', 'hai', 'koleksi', 'list', 'daftar', 'punya', 'ngga', 'tidak'
        ];
        $cleanKeywords = array_filter($keywords, function ($w) use ($stopwords) {
            return strlen($w) >= 3 && !in_array(strtolower($w), $stopwords);
        });

        if (!empty($cleanKeywords)) {
            $matched = Buku::with('kategori')->where(function ($qb) use ($cleanKeywords) {
                foreach ($cleanKeywords as $kw) {
                    $qb->orWhere('judul_buku', 'like', "%{$kw}%")
                       ->orWhere('penulis', 'like', "%{$kw}%")
                       ->orWhere('sinopsis', 'like', "%{$kw}%")
                       ->orWhereHas('kategori', function ($kq) use ($kw) {
                           $kq->where('nama_kategori', 'like', "%{$kw}%");
                       });
                }
            })->take(5)->get();

            if ($matched->isNotEmpty()) {
                return $matched;
            }
        }

        // 3. Deteksi Kategori Spesifik
        if (str_contains($q, 'manga') || str_contains($q, 'komik') || str_contains($q, 'anime') || str_contains($q, 'jepang')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Manga');
            })->inRandomOrder()->take(5)->get();
        }

        if (str_contains($q, 'novel') || str_contains($q, 'fiksi') || str_contains($q, 'sastra') || str_contains($q, 'klasik') || str_contains($q, 'cerita')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->whereIn('nama_kategori', ['Novel', 'Fiksi']);
            })->inRandomOrder()->take(5)->get();
        }

        if (str_contains($q, 'teknologi') || str_contains($q, 'coding') || str_contains($q, 'program') || str_contains($q, 'software') || str_contains($q, 'komputer') || str_contains($q, 'it')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Teknologi');
            })->take(5)->get();
        }

        if (str_contains($q, 'sains') || str_contains($q, 'science') || str_contains($q, 'alam') || str_contains($q, 'fisika') || str_contains($q, 'astronomi')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Sains');
            })->take(5)->get();
        }

        if (str_contains($q, 'filosofi') || str_contains($q, 'filsafat') || str_contains($q, 'stoik') || str_contains($q, 'renungan')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Filosofi');
            })->take(5)->get();
        }

        if (str_contains($q, 'bisnis') || str_contains($q, 'ekonomi') || str_contains($q, 'investasi') || str_contains($q, 'finansial') || str_contains($q, 'keuangan') || str_contains($q, 'startup')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Bisnis');
            })->take(5)->get();
        }

        if (str_contains($q, 'sejarah') || str_contains($q, 'perang') || str_contains($q, 'history')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Sejarah');
            })->take(5)->get();
        }

        if (str_contains($q, 'biografi') || str_contains($q, 'tokoh') || str_contains($q, 'kisah hidup')) {
            return Buku::with('kategori')->whereHas('kategori', function ($k) {
                $k->where('nama_kategori', 'Biografi');
            })->take(5)->get();
        }

        // 4. Permintaan Rekomendasi Umum / Terpopuler
        if (str_contains($q, 'rekomendasi') || str_contains($q, 'populer') || str_contains($q, 'buku apa') || str_contains($q, 'bagus') || str_contains($q, 'favorit') || str_contains($q, 'baca apa') || str_contains($q, 'pilihan')) {
            return Buku::with('kategori')->inRandomOrder()->take(5)->get();
        }

        return collect();
    }

    /**
     * Smart Instant Local Knowledge Engine
     */
    protected function localKnowledgeEngine(string $query, $relevantBooks): string
    {
        $q = strtolower(trim($query));

        // 1. Guardrail: Pertanyaan di luar ranah perpustakaan
        $outOfScope = [
            'politik', 'presiden', 'menteri', 'partai', 'pilkada', 'pemilu', 'capres',
            'resep', 'masak', 'baking', 'bolu', 'rendang', 'nasi goreng', 'bumbu',
            'cuaca', 'ramalan', 'zodiak', 'horoskop', 'bintang',
            'crypto', 'bitcoin', 'saham', 'trading', 'forex', 'slot', 'judi',
            'kalkulator', 'hitunglah', 'rumus matematika', 'aljabar', 'integral',
            'lirik lagu', 'chord gitar', 'kunci gitar',
            'pacar', 'jodoh', 'percintaan', 'kencan', 'selingkuh',
            'game', 'cheat', 'mobile legends', 'free fire', 'pubg', 'genshin',
            'buatkan script', 'buatkan kode python', 'bikin html', 'bikin css'
        ];

        foreach ($outOfScope as $bad) {
            if (str_contains($q, $bad)) {
                return "Maaf, sebagai Asisten Pustakawan Readify, saya hanya dapat membantu pertanyaan seputar perpustakaan, koleksi buku, rekomendasi bacaan, tata cara peminjaman, dan layanan Readify. Ada informasi buku atau perpustakaan yang bisa saya bantu?";
            }
        }

        // 2. Salam & Sapaan Ramah
        $salamList = ['halo', 'hai', 'hello', 'hi', 'hey', 'p', 'tes', 'test', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam', 'assalamualaikum', 'salam'];
        if (in_array($q, $salamList) || preg_match('/^(halo|hai|hello|hi|p)\b/i', $q)) {
            $totalBuku = Buku::count();
            return "Halo! Selamat datang di **Readify Library**.\n\nSaya **Readify AI**, asisten pustakawan virtual Anda. Saat ini perpustakaan kami memiliki lebih dari **{$totalBuku} koleksi buku terkurasi** (Manga, Novel Dunia, Sains, Teknologi, Bisnis, dan Filosofi).\n\nAda yang bisa saya bantu hari ini? Anda bisa menanyakan:\n" .
                "• **Rekomendasi buku** (contoh: *\"rekomendasi manga populer\"* atau *\"novel klasik terbaik\"*)\n" .
                "• **Cari buku atau pengarang** (contoh: *\"apakah ada buku Clean Code?\"*)\n" .
                "• **Lokasi rak buku** di perpustakaan\n" .
                "• **Aturan peminjaman & denda**\n" .
                "• **Panduan mengusulkan buku baru** bagi anggota.";
        }

        // 3. Siapa kamu / Tentang Readify
        if (str_contains($q, 'siapa kamu') || str_contains($q, 'kamu siapa') || str_contains($q, 'tentang readify') || str_contains($q, 'apa itu readify') || str_contains($q, 'bisa bantu apa') || str_contains($q, 'fitur')) {
            $totalBuku = Buku::count();
            return "**Tentang Readify & AI Pustakawan:**\n\n" .
                "**Readify** adalah sistem perpustakaan digital modern berstandar sertifikasi BNSP yang memadukan kenyamanan katalog buku fisik dan digital.\n\n" .
                "• **Total Koleksi:** {$totalBuku} judul buku pilihan (Manga, Novel Klasik, Teknologi, Sains, dll).\n" .
                "• **Fitur Unggulan:** Booking peminjaman online instan, pencarian live cepat, struk peminjaman digital, ruang diskusi komunitas literasi, dan asisten cerdas Pustakawan AI.\n" .
                "• **Peran Saya:** Membantu Anda menemukan buku favorit, menunjukkan nomor rak buku, serta memberikan informasi seputar layanan perpustakaan secara cepat dan tepat.";
        }

        // 4. Aturan Durasi Peminjaman & Denda (Dicek sebelum pengembalian agar pertanyaan denda tepat sasaran)
        if (str_contains($q, 'denda') || str_contains($q, 'terlambat') || str_contains($q, 'aturan pinjam') || str_contains($q, 'berapa hari') || str_contains($q, 'batas waktu') || str_contains($q, 'durasi')) {
            return "**Aturan Durasi Peminjaman & Denda di Readify:**\n\n" .
                "• **Durasi Peminjaman Standar:** Maksimal **7 hari** per transaksi peminjaman.\n" .
                "• **Tarif Denda Keterlambatan:** **Rp 1.000 per hari** untuk setiap buku yang terlambat dikembalikan.\n" .
                "• **Pembayaran Denda:** Dapat dibayarkan langsung kepada Petugas saat mengembalikan buku di perpustakaan, atau dikonfirmasi oleh Admin melalui menu Denda.\n" .
                "• **Pengingat:** Anda dapat mengecek sisa hari pinjaman pada menu **Pinjaman Saya** di dashboard anggota.";
        }

        // 5. Panduan Cara Pinjam Buku (Booking Online)
        if (str_contains($q, 'cara pinjam') || str_contains($q, 'cara meminjam') || str_contains($q, 'langkah pinjam') || str_contains($q, 'booking') || str_contains($q, 'bagaimana meminjam') || str_contains($q, 'prosedur pinjam')) {
            return "**Panduan Meminjam Buku di Readify:**\n\n" .
                "1. **Pilih Buku:** Buka menu **Katalog** dan pilih buku yang ingin Anda baca.\n" .
                "2. **Ajukan Pinjaman:** Klik tombol **Pinjam Buku** pada halaman detail buku untuk membuat booking peminjaman.\n" .
                "3. **Dapatkan Kode Booking:** Anda akan mendapatkan Kode Booking unik (misalnya: `BK250224ABCD`).\n" .
                "4. **Pengambilan Buku:** Kunjungi perpustakaan dan tunjukkan Kode Booking atau Kartu Anggota Anda ke Petugas di loket sirkulasi.\n" .
                "5. **Masa Pinjam:** Buku dapat dipinjam selama maksimal **7 hari** terhitung sejak tanggal konfirmasi peminjaman.";
        }

        // 6. Panduan Cara Mengembalikan Buku
        if (str_contains($q, 'kembali') || str_contains($q, 'pengembalian') || str_contains($q, 'mengembalikan')) {
            return "**Panduan Pengembalian Buku:**\n\n" .
                "1. Bawa buku fisik ke loket sirkulasi perpustakaan sebelum batas tanggal kembali (7 hari).\n" .
                "2. Petugas akan memindai buku dan mengubah status transaksi menjadi **Dikembalikan**.\n" .
                "3. Jika ada keterlambatan, lunasi denda Rp 1.000 / hari per buku langsung di loket.\n" .
                "4. Struk bukti transaksi pengembalian dapat Anda unduh melalui menu **Riwayat Pinjaman**.";
        }

        // 7. Panduan Mengusulkan Buku Baru ("Usul Buku")
        if (str_contains($q, 'usul') || str_contains($q, 'ajukan') || str_contains($q, 'nambah buku') || str_contains($q, 'tambah buku') || str_contains($q, 'usulan')) {
            return "**Cara Mengusulkan Buku Baru di Readify:**\n\n" .
                "Sebagai anggota terdaftar, Anda dapat merekomendasikan buku baru untuk diadakan di perpustakaan:\n\n" .
                "1. Buka menu **Usulkan Buku** (`/ajukan-buku`) di bilah navigasi.\n" .
                "2. Lengkapi formulir: Judul Buku, Penulis, Penerbit, Tahun Terbit, Kategori, serta Alasan Pengusulan.\n" .
                "3. Klik tombol **Kirim Pengajuan**.\n" .
                "4. Admin akan meninjau usulan Anda. Jika disetujui (ACC), Admin melengkapi stok serta sampul buku dan langsung menerbitkannya ke katalog!";
        }

        // 8. Denah & Lokasi Rak Buku
        if (str_contains($q, 'rak') || str_contains($q, 'lokasi') || str_contains($q, 'dimana letak') || str_contains($q, 'posisi buku') || str_contains($q, 'denah')) {
            return "**Denah Lokasi Rak Buku di Perpustakaan Readify:**\n\n" .
                "• **Rak M-01 s/d M-15:** Koleksi Manga & Komik Grafis (One Piece, Berserk, Jujutsu Kaisen, Spy x Family, dll)\n" .
                "• **Rak E-01 s/d E-19:** Novel Fiksi, Klasik & Sastra Dunia (1984, The Great Gatsby, Crime and Punishment, Pride and Prejudice, dll)\n" .
                "• **Rak T-01 s/d T-05:** Teknologi Informasi, Pemrograman, Rekayasa Software & Algoritma (Clean Code, Pragmatic Programmer, SICP, dll)\n" .
                "• **Rak E-20 s/d E-22:** Sains & Alam Semesta, Biografi Tokoh, Filosofi & Bisnis.\n\n*Tips: Setiap buku fisik di perpustakaan memiliki stiker nomor rak di bagian punggung buku untuk memudahkan pencarian.*";
        }

        // 9. Komunitas & Diskusi Literasi
        if (str_contains($q, 'komunitas') || str_contains($q, 'forum') || str_contains($q, 'posting') || str_contains($q, 'diskusi') || str_contains($q, 'feed')) {
            return "**Ruang Komunitas Literasi Readify:**\n\n" .
                "Readify memiliki fitur **Komunitas** (`/komunitas`) di mana seluruh anggota dapat:\n" .
                "• Berbagi review, ulasan, atau kutipan buku favorit.\n" .
                "• Berdiskusi santai dan bertukar ide mengenai jalan cerita buku.\n" .
                "• Memberikan apresiasi (Like) dan komentar pada postingan sesama pembaca.\n\nKunjungi menu **Komunitas** di bilah menu untuk mulai bergabung dalam diskusi!";
        }

        // 10. Ungkapan Terima Kasih & Penutup
        if (preg_match('/\b(terima kasih|makasih|thanks|thank you|tengkyu|ok|oke|siap|mantap|keren|good|sip)\b/i', $q)) {
            return "Sama-sama! Senang sekali bisa membantu Anda. Selamat membaca dan menikmati setiap lembaran buku di Perpustakaan Readify! Jika ada hal lain yang ingin ditanyakan, saya selalu siap membantu.";
        }

        // 11. Hasil Pencarian Buku Relevan (RAG)
        if ($relevantBooks->isNotEmpty()) {
            $text = "**Berikut koleksi buku yang relevan di Perpustakaan Readify:**\n\n";
            foreach ($relevantBooks as $b) {
                $cats = $b->kategori->pluck('nama_kategori')->implode(', ');
                $text .= "• **{$b->judul_buku}** karya *{$b->penulis}*\n";
                $text .= "  - Kategori: {$cats} | Lokasi: **{$b->lokasi_rak}** | Stok: **{$b->stok} eks**\n\n";
            }
            $text .= "Anda dapat melihat rincian sinopsis dan langsung meminjam buku melalui kartu di atas atau menu **Katalog**!";
            return $text;
        }

        // 12. Respon Fallback Cerdas jika tidak ada pencarian buku spesifik
        return "Halo! Saya siap membantu Anda di Perpustakaan Readify. Anda bisa menanyakan:\n" .
            "• Rekomendasi bacaan (*\"rekomendasi novel klasik\"*, *\"manga populer\"*, *\"buku teknologi\"*)\n" .
            "• Lokasi rak buku fisik (*\"dimana letak rak manga?\"*)\n" .
            "• Ketentuan peminjaman & denda (*\"berapa hari maksimal pinjam?\"*)\n" .
            "• Cara mengajukan usulan buku baru (*\"cara usul buku baru\"*)\n\nSilakan ketik pertanyaan Anda!";
    }

    /**
     * Integrasi Resmi Google Gemini API (jika GEMINI_API_KEY tersedia)
     */
    protected function callGemini(string $userMessage, array $history, $relevantBooks, string $apiKey): ?string
    {
        try {
            $systemPrompt = $this->buildGeminiSystemPrompt($relevantBooks);

            $contents = [];
            $recentHistory = array_slice($history, -4);
            foreach ($recentHistory as $msg) {
                if (isset($msg['role']) && isset($msg['content'])) {
                    $role = $msg['role'] === 'assistant' ? 'model' : 'user';
                    $contents[] = [
                        'role' => $role,
                        'parts' => [['text' => Str::limit($msg['content'], 300)]]
                    ];
                }
            }
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $userMessage]]
            ];

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . urlencode($apiKey);

            $response = Http::timeout(2.5)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]]
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 600,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if (!empty($reply)) {
                    return trim($reply);
                }
            }
        } catch (\Throwable $e) {
            // Fallback gracefully to local knowledge engine
        }

        return null;
    }

    /**
     * Buat System Prompt ringkas untuk Gemini
     */
    protected function buildGeminiSystemPrompt($relevantBooks): string
    {
        $totalBuku = Buku::count();
        $bukuContext = "";
        if ($relevantBooks->isNotEmpty()) {
            $bukuContext = "\nBuku Terkait di Readify:\n";
            foreach ($relevantBooks as $b) {
                $bukuContext .= "- \"{$b->judul_buku}\" ({$b->penulis}) - Lokasi: {$b->lokasi_rak}, Stok: {$b->stok}\n";
            }
        }

        return "Kamu adalah Readify AI, asisten pustakawan virtual resmi Perpustakaan Readify yang ramah, sopan, dan berwawasan luas. Total koleksi: {$totalBuku} buku. Aturan pinjam: maksimal 7 hari, denda Rp 1.000/hari. Lokasi rak: Manga di Rak M-01 s/d M-15, Novel di Rak E-01 s/d E-19, Teknologi di Rak T-01 s/d T-05, Sains/Bisnis di Rak E-20 s/d E-22. Jawablah hanya hal-hal seputar perpustakaan dan buku. Jika di luar perpustakaan, tolak dengan santun.{$bukuContext}";
    }
}
