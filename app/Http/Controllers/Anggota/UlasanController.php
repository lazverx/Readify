<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    /**
     * Simpan ulasan baru untuk buku
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:buku,id_buku',
            'rating' => 'required|integer|min:1|max:5',
            'isi_ulasan' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Validasi: hanya anggota yang sudah pinjam buku boleh kasih ulasan
        if (!$user->sudahMeminjamBuku($request->id_buku)) {
            return redirect()->back()
                ->with('error', 'Anda harus meminjam buku ini terlebih dahulu sebelum memberikan ulasan.');
        }

        // Validasi: cek apakah sudah pernah mengulas
        if ($user->sudahMengulasBuku($request->id_buku)) {
            return redirect()->back()
                ->with('error', 'Anda sudah pernah memberikan ulasan untuk buku ini.');
        }

        // Cek status akun harus aktif
        if ($user->status !== 'active') {
            return redirect()->back()
                ->with('error', 'Akun Anda harus aktif untuk memberikan ulasan.');
        }

        try {
            Ulasan::create([
                'id_buku' => $request->id_buku,
                'id_pengguna' => $user->id_pengguna,
                'rating' => $request->rating,
                'isi_ulasan' => $request->isi_ulasan,
            ]);

            return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda telah disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan ulasan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Hapus ulasan (hanya owner yang bisa hapus)
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        $ulasan = Ulasan::where('id_ulasan', $id)
            ->where('id_pengguna', $user->id_pengguna)
            ->first();

        if (!$ulasan) {
            return redirect()->back()
                ->with('error', 'Ulasan tidak ditemukan atau Anda tidak memiliki izin untuk menghapus.');
        }

        try {
            $ulasan->delete();

            return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus ulasan. Silakan coba lagi.');
        }
    }
}
