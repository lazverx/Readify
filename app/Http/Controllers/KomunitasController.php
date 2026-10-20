<?php

namespace App\Http\Controllers;

use App\Models\PostinganKomunitas;
use App\Models\KomentarKomunitas;
use App\Models\LikePostingan;
use App\Models\Buku;
use App\Models\Pengguna;
use App\Models\Notifikasi;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KomunitasController extends Controller
{
    /**
     * Tampilkan Feed Komunitas Literasi
     */
    public function index(Request $request)
    {
        $query = PostinganKomunitas::with([
            'pengguna.anggota',
            'buku.kategori',
            'komentar.pengguna.anggota',
            'likes'
        ]);

        // Filter tipe postingan (diskusi, review, kutipan, rekomendasi)
        if ($request->filled('tipe') && $request->tipe !== 'semua') {
            $query->where('tipe', $request->tipe);
        }

        // Filter buku tertentu
        if ($request->filled('buku_id')) {
            $query->where('id_buku', $request->buku_id);
        }

        // Search konten atau judul buku
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('konten', 'like', "%{$search}%")
                  ->orWhereHas('buku', function ($qb) use ($search) {
                      $qb->where('judul_buku', 'like', "%{$search}%")
                         ->orWhere('penulis', 'like', "%{$search}%");
                  })
                  ->orWhereHas('pengguna.anggota', function ($qp) use ($search) {
                      $qp->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'populer') {
            $query->orderByDesc('jumlah_like')->orderByDesc('dibuat_pada');
        } elseif ($sort === 'diskusi_terbanyak') {
            $query->orderByDesc('jumlah_komentar')->orderByDesc('dibuat_pada');
        } else {
            $query->orderByDesc('dibuat_pada');
        }

        $postingan = $query->paginate(10)->withQueryString();

        // 1. Buku Paling Ramai Dibicarakan (Top 4)
        $bukuTrending = Buku::has('postinganKomunitas')
            ->withCount('postinganKomunitas')
            ->orderByDesc('postingan_komunitas_count')
            ->limit(4)
            ->get();

        // 2. Anggota Paling Aktif di Komunitas (Top 4)
        $topKontributor = Pengguna::with('anggota')
            ->whereHas('anggota')
            ->where('status', 'active')
            ->withCount(['postinganKomunitas' => function ($q) {
                $q->whereNotNull('id_postingan');
            }])
            ->orderByDesc('postingan_komunitas_count')
            ->limit(4)
            ->get();

        // 3. Daftar buku untuk pilihan tag di composer box
        $daftarBuku = Buku::select('id_buku', 'judul_buku', 'penulis', 'stok', 'lokasi_rak')
            ->orderBy('judul_buku', 'asc')
            ->get();

        // 4. Statistik Komunitas
        $totalPostingan = PostinganKomunitas::count();
        $totalKomentar = KomentarKomunitas::count();

        return view('komunitas.index', compact(
            'postingan',
            'bukuTrending',
            'topKontributor',
            'daftarBuku',
            'totalPostingan',
            'totalKomentar'
        ));
    }

    /**
     * Simpan postingan baru
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi status akun
        if ($user->status !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda belum aktif. Hanya akun aktif yang dapat berpartisipasi di komunitas.');
        }

        $request->validate([
            'konten' => 'required|string|min:5|max:3000',
            'tipe' => 'required|in:diskusi,review,kutipan,rekomendasi',
            'id_buku' => 'nullable|exists:buku,id_buku',
            'rating' => 'nullable|integer|min:1|max:5',
        ], [
            'konten.required' => 'Tuliskan pemikiran atau ulasan Anda terlebih dahulu.',
            'konten.min' => 'Konten postingan minimal 5 karakter.',
            'konten.max' => 'Konten postingan maksimal 3.000 karakter.',
        ]);

        $post = PostinganKomunitas::create([
            'id_pengguna' => $user->id_pengguna,
            'id_buku' => $request->id_buku ?: null,
            'tipe' => $request->tipe,
            'rating' => $request->tipe === 'review' ? $request->rating : null,
            'konten' => $request->konten,
            'jumlah_like' => 0,
            'jumlah_komentar' => 0,
        ]);

        LogAktivitas::catat(
            'buat_postingan',
            "Membuat postingan komunitas: " . Str::limit($request->konten, 40),
            $user->id_pengguna
        );

        return redirect()->route('komunitas.index')
            ->with('success', 'Postingan Anda berhasil dibagikan ke Ruang Komunitas!');
    }

    /**
     * Kirim komentar pada postingan
     */
    public function storeKomentar(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->status !== 'active') {
            return redirect()->back()->with('error', 'Akun Anda belum aktif untuk berkomentar.');
        }

        $request->validate([
            'konten' => 'required|string|min:1|max:1000',
        ], [
            'konten.required' => 'Komentar tidak boleh kosong.',
            'konten.max' => 'Komentar maksimal 1.000 karakter.',
        ]);

        $post = PostinganKomunitas::findOrFail($id);

        $komentar = KomentarKomunitas::create([
            'id_postingan' => $post->id_postingan,
            'id_pengguna' => $user->id_pengguna,
            'konten' => $request->konten,
        ]);

        // Increment counter
        $post->increment('jumlah_komentar');

        // Kirim notifikasi ke pemilik postingan jika bukan mengomentari postingan sendiri
        if ($post->id_pengguna !== $user->id_pengguna) {
            $namaPengomentar = $user->anggota->nama_lengkap ?? $user->nama_pengguna;
            Notifikasi::create([
                'id_pengguna' => $post->id_pengguna,
                'tipe' => 'komunitas',
                'judul' => 'Komentar Baru di Postinganmu',
                'pesan' => "{$namaPengomentar} mengomentari: \"" . Str::limit($request->konten, 50) . "\"",
                'link' => route('komunitas.index') . '#post-' . $post->id_postingan,
                'sudah_dibaca' => false,
            ]);
        }

        LogAktivitas::catat(
            'komentar_komunitas',
            "Mengomentari postingan #{$post->id_postingan}: " . Str::limit($request->konten, 35),
            $user->id_pengguna
        );

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dikirim!',
                'komentar' => [
                    'nama' => $user->anggota->nama_lengkap ?? $user->nama_pengguna,
                    'konten' => e($komentar->konten),
                    'waktu' => $komentar->waktu_lalu,
                ]
            ]);
        }

        return redirect()->to(route('komunitas.index') . '#post-' . $post->id_postingan)
            ->with('success', 'Komentar berhasil dikirim!');
    }

    /**
     * Toggle Like pada postingan (AJAX / Form)
     */
    public function toggleLike(Request $request, $id)
    {
        $user = Auth::user();
        $post = PostinganKomunitas::findOrFail($id);

        $existingLike = LikePostingan::where('id_postingan', $post->id_postingan)
            ->where('id_pengguna', $user->id_pengguna)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('jumlah_like');
            $liked = false;
        } else {
            LikePostingan::create([
                'id_postingan' => $post->id_postingan,
                'id_pengguna' => $user->id_pengguna,
            ]);
            $post->increment('jumlah_like');
            $liked = true;
        }

        $freshCount = (int) $post->fresh()->jumlah_like;

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $freshCount,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Hapus postingan (Owner atau Admin/Petugas)
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $post = PostinganKomunitas::findOrFail($id);

        // Hanya pemilik postingan atau admin/petugas yang boleh hapus
        $isOwner = $post->id_pengguna === $user->id_pengguna;
        $isStaff = in_array($user->level_akses, ['admin', 'petugas']);

        if (!$isOwner && !$isStaff) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }

        LogAktivitas::catat(
            'hapus_postingan',
            "Menghapus postingan komunitas #{$post->id_postingan} milik pengguna #{$post->id_pengguna}",
            $user->id_pengguna
        );

        $post->delete();

        return redirect()->route('komunitas.index')
            ->with('success', 'Postingan berhasil dihapus.');
    }

    /**
     * Hapus komentar (Owner komentar, Owner post, atau Admin/Petugas)
     */
    public function destroyKomentar(Request $request, $id)
    {
        $user = Auth::user();
        $komentar = KomentarKomunitas::with('postingan')->findOrFail($id);

        $isOwnerKomentar = $komentar->id_pengguna === $user->id_pengguna;
        $isOwnerPost = $komentar->postingan->id_pengguna === $user->id_pengguna;
        $isStaff = in_array($user->level_akses, ['admin', 'petugas']);

        if (!$isOwnerKomentar && !$isOwnerPost && !$isStaff) {
            return redirect()->back()->with('error', 'Anda tidak berwenang menghapus komentar ini.');
        }

        $postingan = $komentar->postingan;
        $komentar->delete();
        $postingan->decrement('jumlah_komentar');

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
