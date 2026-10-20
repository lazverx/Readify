<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DueNotificationService
{
    /**
     * Periksa jatuh tempo dan kirim notifikasi otomatis
     * 
     * @param int|null $idPengguna Jika diberikan, hanya periksa anggota ini
     * @return int Jumlah notifikasi pengingat yang berhasil dikirim
     */
    public static function checkDueDates(?int $idPengguna = null): int
    {
        $query = Peminjaman::with(['buku', 'pengguna'])
            ->where('status_transaksi', 'dipinjam')
            ->whereNotNull('tgl_jatuh_tempo');

        if ($idPengguna) {
            $query->where('id_pengguna', $idPengguna);
        }

        $pinjamanAktif = $query->get();
        $notifTerkirim = 0;
        $today = Carbon::today();

        foreach ($pinjamanAktif as $peminjaman) {
            $tglTempo = Carbon::parse($peminjaman->tgl_jatuh_tempo)->startOfDay();
            
            // Hitung sisa hari: positif jika belum lewat, negatif jika terlambat
            $sisaHari = (int) $today->diffInDays($tglTempo, false);

            // Kirim notifikasi jika:
            // 1. H-2 (sisaHari = 2)
            // 2. H-1 (sisaHari = 1)
            // 3. Hari H (sisaHari = 0)
            // 4. Terlambat (sisaHari < 0)
            if ($sisaHari <= 2) {
                $notif = Notifikasi::kirimPengingatJatuhTempo($peminjaman, $sisaHari);
                if ($notif) {
                    $notifTerkirim++;
                }
            }
        }

        return $notifTerkirim;
    }

    /**
     * Dapatkan daftar peminjaman yang mendekati jatuh tempo atau terlambat untuk anggota tertentu
     *
     * @param int $idPengguna
     * @return Collection
     */
    public static function getUpcomingDueForUser(int $idPengguna): Collection
    {
        $today = Carbon::today();

        return Peminjaman::with('buku')
            ->where('id_pengguna', $idPengguna)
            ->where('status_transaksi', 'dipinjam')
            ->whereNotNull('tgl_jatuh_tempo')
            ->get()
            ->filter(function ($pinjam) use ($today) {
                $tglTempo = Carbon::parse($pinjam->tgl_jatuh_tempo)->startOfDay();
                $sisaHari = (int) $today->diffInDays($tglTempo, false);
                $pinjam->sisa_hari = $sisaHari;
                return $sisaHari <= 2;
            })
            ->sortBy('sisa_hari')
            ->values();
    }
}
