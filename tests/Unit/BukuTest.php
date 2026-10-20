<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Buku;

class BukuTest extends TestCase
{
    /**
     * Test format tahun terbit buku
     */
    public function test_formatted_tahun_terbit(): void
    {
        $buku = new Buku(['tahun_terbit' => 2024]);
        $this->assertEquals(2024, $buku->formatted_tahun_terbit);

        $bukuKosong = new Buku(['tahun_terbit' => null]);
        $this->assertEquals('Tidak diketahui', $bukuKosong->formatted_tahun_terbit);
    }

    /**
     * Test format jumlah halaman buku
     */
    public function test_formatted_jumlah_halaman(): void
    {
        $buku = new Buku(['jumlah_halaman' => 350]);
        $this->assertEquals('350 halaman', $buku->formatted_jumlah_halaman);

        $bukuKosong = new Buku(['jumlah_halaman' => null]);
        $this->assertEquals('Tidak diketahui', $bukuKosong->formatted_jumlah_halaman);
    }

    /**
     * Test sinopsis preview dipotong maksimal 100 karakter
     */
    public function test_sinopsis_preview_truncation(): void
    {
        $teksPanjang = str_repeat('Buku ini sangat menarik dan mendidik. ', 10);
        $buku = new Buku(['sinopsis' => $teksPanjang]);

        $this->assertLessThanOrEqual(104, strlen($buku->sinopsis_preview));
        $this->assertStringEndsWith('...', $buku->sinopsis_preview);
    }

    /**
     * Test formatting nama bahasa buku
     */
    public function test_formatted_bahasa(): void
    {
        $bukuId = new Buku(['bahasa' => 'id']);
        $this->assertEquals('Indonesia', $bukuId->formatted_bahasa);

        $bukuEn = new Buku(['bahasa' => 'en']);
        $this->assertEquals('English', $bukuEn->formatted_bahasa);

        $bukuJa = new Buku(['bahasa' => 'ja']);
        $this->assertEquals('Japanese', $bukuJa->formatted_bahasa);
    }
}
