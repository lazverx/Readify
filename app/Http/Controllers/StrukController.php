<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class StrukController extends Controller
{
    /**
     * Tampilkan dan cetak struk transaksi peminjaman / pengembalian / denda
     */
    public function show(int $id)
    {
        $user = auth()->user();

        $peminjaman = Peminjaman::with([
            'pengguna.anggota',
            'buku.kategori',
            'denda',
        ])->findOrFail($id);

        // Otorisasi: Anggota hanya boleh mencetak struk miliknya sendiri
        if ($user->isAnggota() && $peminjaman->id_pengguna !== $user->id_pengguna) {
            abort(403, 'Anda tidak memiliki akses ke bukti transaksi ini.');
        }

        // Catat audit log cetak struk
        LogAktivitas::catat('cetak_struk', "Pengguna '{$user->nama_pengguna}' mencetak struk transaksi ID #{$peminjaman->id_peminjaman} (Booking: {$peminjaman->kode_booking}).");

        return view('peminjaman.struk', compact('peminjaman', 'user'));
    }
}
