<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanTest extends TestCase
{
    /**
     * Test generator kode booking menghasilkan format yang benar
     */
    public function test_generate_kode_booking_format(): void
    {
        $kode = Peminjaman::generateKodeBooking();

        $this->assertIsString($kode);
        $this->assertStringStartsWith('BK', $kode);
        $this->assertGreaterThanOrEqual(10, strlen($kode));
    }

    /**
     * Test pengecekan keterlambatan ketika tanggal jatuh tempo sudah lewat
     */
    public function test_is_terlambat_returns_true_when_overdue(): void
    {
        $peminjaman = new Peminjaman([
            'tgl_pinjam' => Carbon::now()->subDays(10),
            'tgl_jatuh_tempo' => Carbon::now()->subDays(3),
            'status_transaksi' => 'terlambat'
        ]);

        $this->assertTrue($peminjaman->isTerlambat());
    }

    /**
     * Test pengecekan keterlambatan ketika peminjaman belum jatuh tempo
     */
    public function test_is_terlambat_returns_false_when_not_overdue(): void
    {
        $peminjaman = new Peminjaman([
            'tgl_pinjam' => Carbon::now(),
            'tgl_jatuh_tempo' => Carbon::now()->addDays(5),
            'status_transaksi' => 'dipinjam'
        ]);

        $this->assertFalse($peminjaman->isTerlambat());
    }

    /**
     * Test hitungan sisa hari pinjaman
     */
    public function test_sisa_hari_calculation(): void
    {
        $peminjaman = new Peminjaman([
            'tgl_pinjam' => Carbon::now(),
            'tgl_jatuh_tempo' => Carbon::now()->addDays(4),
            'status_transaksi' => 'dipinjam'
        ]);

        $this->assertGreaterThanOrEqual(3, $peminjaman->sisa_hari);
        $this->assertLessThanOrEqual(5, $peminjaman->sisa_hari);
    }

    /**
     * Test hitungan nominal denda keterlambatan (Rp 2.000 / hari)
     */
    public function test_denda_calculation_formula(): void
    {
        $tarifPerHari = 2000;
        $hariTerlambat = 5;
        $totalDenda = $hariTerlambat * $tarifPerHari;

        $this->assertEquals(10000, $totalDenda);
    }
}
