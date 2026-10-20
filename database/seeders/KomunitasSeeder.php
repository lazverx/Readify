<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\PostinganKomunitas;
use App\Models\KomentarKomunitas;
use App\Models\LikePostingan;
use Carbon\Carbon;

class KomunitasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat / Ambil beberapa pengguna anggota realistis
        $usersData = [
            [
                'username' => 'naufal_reads',
                'name' => 'Naufal Pratama',
                'email' => 'naufal@readify.id',
                'alamat' => 'Jl. Kaliurang KM 5, Sleman',
                'no_telp' => '081223344551',
            ],
            [
                'username' => 'zahra_literasi',
                'name' => 'Zahra Aurelia',
                'email' => 'zahra@readify.id',
                'alamat' => 'Jl. Gejayan No. 45, Depok',
                'no_telp' => '081334455662',
            ],
            [
                'username' => 'rizky_manga',
                'name' => 'Rizky Hidayat',
                'email' => 'rizky@readify.id',
                'alamat' => 'Jl. Malioboro No. 12, Danurejan',
                'no_telp' => '081556677883',
            ],
            [
                'username' => 'alya_safira',
                'name' => 'Alya Safira',
                'email' => 'alya@readify.id',
                'alamat' => 'Jl. Seturan Raya No. 88, Caturtunggal',
                'no_telp' => '081778899004',
            ],
            [
                'username' => 'dimas_finance',
                'name' => 'Dimas Ardiansyah',
                'email' => 'dimas@readify.id',
                'alamat' => 'Jl. Palagan KM 8, Ngaglik',
                'no_telp' => '081990011225',
            ],
        ];

        $users = [];

        // Ambil akun Lazver jika ada
        $lazver = Pengguna::where('nama_pengguna', 'Lazver')->first();
        if ($lazver) {
            $users['lazver'] = $lazver;
        }

        foreach ($usersData as $u) {
            $pengguna = Pengguna::firstOrCreate(
                ['email' => $u['email']],
                [
                    'nama_pengguna' => $u['username'],
                    'kata_sandi' => Hash::make('password123'),
                    'level_akses' => 'anggota',
                    'status' => 'active',
                    'nomor_anggota' => 'AGT-' . rand(1000, 9999),
                ]
            );

            Anggota::firstOrCreate(
                ['id_pengguna' => $pengguna->id_pengguna],
                [
                    'nama_lengkap' => $u['name'],
                    'alamat' => $u['alamat'],
                    'nomor_telepon' => $u['no_telp'],
                ]
            );

            $users[$u['username']] = $pengguna;
        }

        // Ambil buku-buku relevan dari database
        $bukuSolo = Buku::where('judul_buku', 'like', '%Solo Leveling%')->first();
        $bukuAtomic = Buku::where('judul_buku', 'like', '%Atomic Habits%')->first();
        $bukuClean = Buku::where('judul_buku', 'like', '%Clean Code%')->first();
        $bukuPsycho = Buku::where('judul_buku', 'like', '%Psychology of Money%')->first();
        $bukuHarry = Buku::where('judul_buku', 'like', '%Harry Potter%')->first();
        $bukuAoT = Buku::where('judul_buku', 'like', '%Attack on Titan%')->first();
        $bukuDune = Buku::where('judul_buku', 'like', '%Dune%')->first();
        $bukuJJK = Buku::where('judul_buku', 'like', '%Jujutsu Kaisen%')->first();

        // 2. Data Postingan Realistis & Hidup
        $postsData = [
            [
                'user' => $users['rizky_manga'] ?? null,
                'buku_id' => $bukuSolo?->id_buku,
                'tipe' => 'review',
                'rating' => 5,
                'konten' => "Baru kelar baca Solo Leveling Vol 1 yang baru dipajang di Rak Manga. Asli visual manhwa-nya pas scene double dungeon merinding banget parah! Buat yang baru mau ngikutin kisah Sung Jin-woo, mumpung stok di perpus ada beberapa eks mending buruan pinjam sekarang sebelum keduluan yang lain wkwk 🔥⚔️",
                'minutes_ago' => 45,
                'likes' => 14,
                'comments' => [
                    ['user' => $users['naufal_reads'] ?? null, 'text' => 'Gue kemaren sempet liat di rak B2 bro, artwork pas awakening beneran gokil sih.'],
                    ['user' => $users['lazver'] ?? ($users['dimas_finance'] ?? null), 'text' => 'Wah harus cepet-cepet booking nih sebelum abis dipinjam orang haha.'],
                    ['user' => $users['rizky_manga'] ?? null, 'text' => 'Gas pinjam bro, ga bakal nyesel lu bacanya!'],
                ],
            ],
            [
                'user' => $users['zahra_literasi'] ?? null,
                'buku_id' => $bukuAtomic?->id_buku,
                'tipe' => 'diskusi',
                'rating' => null,
                'konten' => "Ada yang udah nerapin konsep '2-Minute Rule' dari buku Atomic Habits? Gue coba buat rutinitas baca buku sebelum tidur, awalnya males banget tapi pas dipaksa 2 menit doang malah kebablasan baca 1 bab tiap malem haha.\n\nMenurut kalian konsep mana di buku ini yang paling ngaruh ke kehidupan sehari-hari?",
                'minutes_ago' => 120,
                'likes' => 22,
                'comments' => [
                    ['user' => $users['dimas_finance'] ?? null, 'text' => 'Yang konsep 1% better every day ka! Keliatannya sepele tapi pas dijalanin konsisten 3 bulan efeknya berasa banget.'],
                    ['user' => $users['alya_safira'] ?? null, 'text' => 'Habit Stacking juga ngebantu banget Zahra, gue gabungin waktu ngopi pagi sama baca 5 halaman buku perpus.'],
                    ['user' => $users['naufal_reads'] ?? null, 'text' => 'Bagian identity-based habit juga ngena, ubah mindset bukan "mau baca buku" tapi "gue adalah seorang pembaca".'],
                ],
            ],
            [
                'user' => $users['naufal_reads'] ?? null,
                'buku_id' => $bukuClean?->id_buku,
                'tipe' => 'diskusi',
                'rating' => null,
                'konten' => "Lagi baca ulang Clean Code karya Uncle Bob di pojok perpus lantai 2. Paling setuju sama bab 'Meaningful Names'—bikin nama variabel jangan pelit-pelit kek kode rahasia FBI wkwk.\n\nTapi menurut temen-temen programmer di sini, buku ini masih relevan ga sih buat modern development framework kayak sekarang?",
                'minutes_ago' => 210,
                'likes' => 18,
                'comments' => [
                    ['user' => $users['rizky_manga'] ?? null, 'text' => 'Prinsip dasarnya tetep abadi bro, terutama SRP (Single Responsibility) & readability.'],
                    ['user' => $users['lazver'] ?? ($users['dimas_finance'] ?? null), 'text' => 'Setuju, tools boleh ganti tapi cara nulis kode yang bersih dan gampang dibaca orang lain ga bakal basi.'],
                ],
            ],
            [
                'user' => $users['dimas_finance'] ?? null,
                'buku_id' => $bukuPsycho?->id_buku,
                'tipe' => 'kutipan',
                'rating' => null,
                'konten' => "\"Doing well with money has a little to do with how smart you are and a lot to do with how you behave.\"\n— Morgan Housel, The Psychology of Money.\n\nKutipan simpel tapi nampol banget. Mengelola uang itu ternyata bukan cuma soal rumus matematika rumit, tapi tentang bagaimana kita mengendalikan ego dan emosi diri sendiri.",
                'minutes_ago' => 360,
                'likes' => 27,
                'comments' => [
                    ['user' => $users['zahra_literasi'] ?? null, 'text' => 'Bab tentang "Man in the Car Paradox" ngena banget sih. Orang beli barang mewah biar dikagumi, padahal orang lain cuma kagum sama barangnya bukan orangnya.'],
                    ['user' => $users['naufal_reads'] ?? null, 'text' => 'Buku non-fiksi yang wajib dibaca sekali seumur hidup 💯'],
                ],
            ],
            [
                'user' => $users['alya_safira'] ?? null,
                'buku_id' => $bukuHarry?->id_buku,
                'tipe' => 'review',
                'rating' => 5,
                'konten' => "Re-reading Harry Potter edisi terjemahan perpus Readify! Bagi gue seri ketiga (Prisoner of Azkaban) ini yang paling berkesan dari seluruh saga: perkenalan Sirius Black, Remus Lupin, plus konsep Time-Turner yang jenius banget. Bener-bener nostalgia masa kecil 🦉⚡ Siapa karakter favorit kalian di Hogwarts?",
                'minutes_ago' => 480,
                'likes' => 19,
                'comments' => [
                    ['user' => $users['alya_safira'] ?? null, 'text' => 'Tim Sirius Black hadir! Karakter paling berjiwa bebas.'],
                    ['user' => $users['rizky_manga'] ?? null, 'text' => 'Profesor Snape tetep the best written character sepanjang seri sih.'],
                ],
            ],
            [
                'user' => $users['lazver'] ?? ($users['naufal_reads'] ?? null),
                'buku_id' => null,
                'tipe' => 'diskusi',
                'rating' => null,
                'konten' => "Koleksi buku sama manga di perpus Readify sekarang makin lengkap banget mantap! Ada rekomendasi novel sci-fi atau fiksi seru ga guys buat nemenin akhir pekan ini? Kalau bisa yang ga terlalu berat biar santai bacanya.",
                'minutes_ago' => 600,
                'likes' => 15,
                'comments' => [
                    ['user' => $users['alya_safira'] ?? null, 'text' => 'Coba baca Harry Potter atau Percy Jackson kalau mau yang ringan dan seru alurnya!'],
                    ['user' => $users['dimas_finance'] ?? null, 'text' => 'Kalau mau yang agak berbobot tapi nagih coba Dune bro, di Rak Novel ada.'],
                ],
            ],
            [
                'user' => $users['rizky_manga'] ?? null,
                'buku_id' => $bukuAoT?->id_buku,
                'tipe' => 'rekomendasi',
                'rating' => null,
                'konten' => "Buat temen-temen yang belum pernah baca manga Attack on Titan versi fisik, mumpung Vol 1 ada di Rak Manga A1 coba luangin waktu baca deh. Pacing chapter pertamanya ga ada obat, langsung dikasih teror Colossal Titan tanpa ampun dari halaman pertama!",
                'minutes_ago' => 840,
                'likes' => 31,
                'comments' => [
                    ['user' => $users['naufal_reads'] ?? null, 'text' => 'Plot twist dari awal sampe akhir beneran jenius sih Isayama.'],
                ],
            ],
            [
                'user' => $users['dimas_finance'] ?? null,
                'buku_id' => $bukuDune?->id_buku,
                'tipe' => 'review',
                'rating' => 4,
                'konten' => "Baru selesai membaca sepertiga buku Dune karya Frank Herbert. Bukunya tebel banget dan butuh fokus ekstra karena istilah planet Arrakis-nya banyak, tapi detail politik sama ekologinya beneran masterpiece sci-fi! Worth reading banget.",
                'minutes_ago' => 1200,
                'likes' => 12,
                'comments' => [
                    ['user' => $users['zahra_literasi'] ?? null, 'text' => 'Setuju, awal-awal agak lambat tapi pas Paul Atreides ke gurun pasir langsung ga bisa berhenti baca.'],
                ],
            ],
        ];

        // 3. Masukkan Postingan, Komentar & Likes ke Database
        foreach ($postsData as $p) {
            if (!$p['user']) {
                continue;
            }

            $waktuPost = Carbon::now()->subMinutes($p['minutes_ago']);

            $post = PostinganKomunitas::create([
                'id_pengguna' => $p['user']->id_pengguna,
                'id_buku' => $p['buku_id'],
                'tipe' => $p['tipe'],
                'rating' => $p['rating'],
                'konten' => $p['konten'],
                'jumlah_like' => $p['likes'],
                'jumlah_komentar' => count($p['comments']),
                'dibuat_pada' => $waktuPost,
                'diperbarui_pada' => $waktuPost,
            ]);

            // Seeding komentar
            foreach ($p['comments'] as $cIndex => $kom) {
                if (!$kom['user']) {
                    continue;
                }

                $waktuKom = $waktuPost->copy()->addMinutes(15 * ($cIndex + 1));

                KomentarKomunitas::create([
                    'id_postingan' => $post->id_postingan,
                    'id_pengguna' => $kom['user']->id_pengguna,
                    'konten' => $kom['text'],
                    'dibuat_pada' => $waktuKom,
                    'diperbarui_pada' => $waktuKom,
                ]);
            }

            // Seeding likes autentik dari beberapa user
            foreach ($users as $uObj) {
                if ($uObj && rand(0, 1) === 1) {
                    LikePostingan::firstOrCreate([
                        'id_postingan' => $post->id_postingan,
                        'id_pengguna' => $uObj->id_pengguna,
                    ], [
                        'dibuat_pada' => $waktuPost->copy()->addMinutes(5),
                    ]);
                }
            }

            // Perbarui jumlah like aktual di tabel postingan
            $realLikesCount = LikePostingan::where('id_postingan', $post->id_postingan)->count();
            $post->update([
                'jumlah_like' => max($realLikesCount, $p['likes']),
            ]);
        }
    }
}
