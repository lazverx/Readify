<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\PengajuanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengajuanBukuController extends Controller
{
    /**
     * Tampilkan semua pengajuan buku (admin)
     */
    public function index(Request $request)
    {
        $query = PengajuanBuku::with(['buku', 'pengguna'])->latest('dibuat_pada');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('nama_penulis', 'like', "%{$search}%")
                    ->orWhere('nama_pengusul', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->paginate(10)->withQueryString();

        // Tandai semua sebagai sudah dibaca ketika admin membuka halaman ini
        PengajuanBuku::where('sudah_dibaca', false)->update(['sudah_dibaca' => true]);

        return view('admin.pengajuan-buku.index', compact('pengajuan'));
    }

    /**
     * Tampilkan detail satu pengajuan
     */
    public function show($id)
    {
        $pengajuan = PengajuanBuku::with(['buku.kategori', 'pengguna.anggota'])->findOrFail($id);

        // Tandai sebagai sudah dibaca
        if (!$pengajuan->sudah_dibaca) {
            $pengajuan->update(['sudah_dibaca' => true]);
        }

        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        return view('admin.pengajuan-buku.show', compact('pengajuan', 'kategoriList'));
    }

    /**
     * Update status pengajuan (Tolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);

        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pengajuan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        $label = $request->status === 'disetujui' ? 'disetujui' : 'ditolak';

        // Kirim notifikasi ke pengguna yang mengajukan (jika ada id_pengguna)
        if ($pengajuan->id_pengguna) {
            $emoji = $request->status === 'disetujui' ? '✅' : '❌';
            $pesanStatus = $request->status === 'disetujui'
                ? "Pengajuan buku \"{$pengajuan->judul_buku}\" telah disetujui oleh admin."
                : "Pengajuan buku \"{$pengajuan->judul_buku}\" telah ditolak oleh admin.";

            if ($request->catatan_admin) {
                $pesanStatus .= " Catatan admin: {$request->catatan_admin}";
            }

            Notifikasi::create([
                'id_pengguna' => $pengajuan->id_pengguna,
                'tipe' => 'status_pengajuan',
                'judul' => "{$emoji} Pengajuan Buku " . ucfirst($label),
                'pesan' => $pesanStatus,
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'sudah_dibaca' => false,
            ]);
        }

        return redirect()->route('admin.pengajuan-buku.show', $pengajuan->id_pengajuan)
            ->with('success', "Pengajuan buku \"{$pengajuan->judul_buku}\" telah {$label}.");
    }

    /**
     * ACC Pengajuan & Terbitkan Buku ke Katalog (Lengkapi Sampul & Data Kurang)
     */
    public function accAndPublish(Request $request, $id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);

        $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:100',
            'isbn' => 'nullable|string|max:20',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'jumlah_halaman' => 'nullable|integer|min:1|max:10000',
            'bahasa' => 'nullable|string|in:id,en,ar,zh,fr,de,ja,ko',
            'lokasi_rak' => 'nullable|string|max:50',
            'sinopsis' => 'nullable|string',
            'kategori' => 'nullable|array',
            'kategori.*' => 'exists:kategori,id_kategori',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'catatan_admin' => 'nullable|string|max:1000',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'stok.required' => 'Stok buku wajib diisi minimal 0.',
            'sampul.image' => 'File sampul harus berupa gambar valid (JPEG, PNG, JPG, WebP).',
            'sampul.max' => 'Ukuran file sampul maksimal 2MB.',
        ]);

        // Simpan File Sampul
        $sampulPath = null;
        if ($request->hasFile('sampul')) {
            $sampulPath = $request->file('sampul')->store('sampul', 'public');
        } else {
            // Gunakan cover sample dari storage jika admin tidak upload agar tampilan tidak rusak
            $sampleCovers = glob(storage_path('app/public/sampul/*.{jpg,jpeg,png}'), GLOB_BRACE);
            if (!empty($sampleCovers)) {
                $slug = Str::slug($request->judul_buku);
                $fallbackFilename = $slug . '-cover.jpg';
                $targetPath = storage_path('app/public/sampul/' . $fallbackFilename);
                if (!file_exists($targetPath)) {
                    copy($sampleCovers[0], $targetPath);
                }
                $sampulPath = 'sampul/' . $fallbackFilename;
            }
        }

        // 1. Buat Buku Baru di Database
        $buku = Buku::create([
            'judul_buku' => $request->judul_buku,
            'penulis' => $request->penulis,
            'isbn' => $request->isbn,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'jumlah_halaman' => $request->jumlah_halaman,
            'bahasa' => $request->bahasa ?? 'id',
            'lokasi_rak' => $request->lokasi_rak ?? 'Rak A-01',
            'sinopsis' => $request->sinopsis ?? $pengajuan->alasan_pengusulan,
            'sampul' => $sampulPath,
        ]);

        // 2. Hubungkan Relasi Kategori
        if ($request->has('kategori') && is_array($request->kategori)) {
            $buku->kategori()->sync($request->kategori);
        } elseif ($pengajuan->kategori) {
            $matchingKat = Kategori::where('nama_kategori', 'like', "%{$pengajuan->kategori}%")->first();
            if ($matchingKat) {
                $buku->kategori()->sync([$matchingKat->id_kategori]);
            }
        }

        // 3. Update Status Pengajuan Buku
        $catatan = $request->filled('catatan_admin')
            ? $request->catatan_admin
            : 'Usulan buku Anda telah disetujui dan telah resmi ditambahkan ke katalog perpustakaan.';

        $pengajuan->update([
            'status' => 'disetujui',
            'id_buku' => $buku->id_buku,
            'catatan_admin' => $catatan,
        ]);

        // 4. Kirim Notifikasi Sukses ke Anggota Pengusul
        if ($pengajuan->id_pengguna) {
            Notifikasi::create([
                'id_pengguna' => $pengajuan->id_pengguna,
                'tipe' => 'status_pengajuan',
                'judul' => '🎉 Usulan Buku Diterima & Terbit!',
                'pesan' => "Selamat! Usulan buku Anda \"{$buku->judul_buku}\" telah disetujui oleh admin dan resmi tersedia di katalog perpustakaan pada {$buku->lokasi_rak}.",
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'sudah_dibaca' => false,
            ]);
        }

        return redirect()->route('admin.pengajuan-buku.show', $pengajuan->id_pengajuan)
            ->with('success', "Buku \"{$buku->judul_buku}\" berhasil disetujui dan resmi diterbitkan ke katalog perpustakaan!");
    }

    /**
     * Hapus pengajuan
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);
        $judul = $pengajuan->judul_buku;
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan-buku.index')
            ->with('success', "Pengajuan buku \"{$judul}\" berhasil dihapus.");
    }
}

