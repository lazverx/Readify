<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DueNotificationService;

class CekJatuhTempoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'peminjaman:cek-jatuh-tempo {--user= : ID Pengguna tertentu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periksa peminjaman buku yang mendekati jatuh tempo (H-2, H-1, Hari H, terlambat) dan kirim notifikasi otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user') ? (int) $this->option('user') : null;

        $this->info('Memulai pengecekan tanggal jatuh tempo peminjaman...');

        $jumlahTerkirim = DueNotificationService::checkDueDates($userId);

        $this->info("Pengecekan selesai! Sebanyak {$jumlahTerkirim} notifikasi pengingat berhasil dikirim.");

        return Command::SUCCESS;
    }
}
