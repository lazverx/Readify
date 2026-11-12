<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\KoleksiPribadi;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OnboardingRegistrationTest extends TestCase
{
    #[Test]
    public function halaman_registrasi_menampilkan_wizard_onboarding_dan_data_kategori()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Buat Akun Anggota Readify');
        $response->assertSee('Apa yang Ingin Anda Baca?');
        $response->assertSee('Buku Mana yang Ingin Anda Baca Pertama?');
        $response->assertSee('Seberapa Sering Anda Ingin Membaca?');
    }

    #[Test]
    public function pendaftaran_anggota_baru_menyimpan_preferensi_kategori_target_dan_koleksi_buku_awal()
    {
        $kategori1 = Kategori::firstOrCreate(['nama_kategori' => 'Fiksi']);
        $kategori2 = Kategori::firstOrCreate(['nama_kategori' => 'Sains']);
        $kategori3 = Kategori::firstOrCreate(['nama_kategori' => 'Teknologi']);

        $buku1 = Buku::firstOrCreate(
            ['isbn' => '978-0000000001'],
            [
                'judul_buku' => 'Buku Uji Personalisasi 1',
                'penulis' => 'Penulis Uji',
                'penerbit' => 'Penerbit Uji',
                'stok' => 5,
                'bahasa' => 'id',
            ]
        );

        $unique = time();
        $payload = [
            'nama_lengkap' => 'Pembaca Personalisasi ' . $unique,
            'nama_pengguna' => 'reader_' . $unique,
            'email' => 'reader_' . $unique . '@example.com',
            'kata_sandi' => 'password123',
            'nomor_telepon' => '08123456789',
            'alamat' => 'Jl. Literasi Digital No. 42',
            'preferensi_kategori' => [$kategori1->id_kategori, $kategori2->id_kategori, $kategori3->id_kategori],
            'target_baca_bulanan' => 4,
            'starter_books' => [$buku1->id_buku],
        ];

        $response = $this->post(route('register'), $payload);

        $response->assertRedirect(route('anggota.dashboard'));

        $pengguna = Pengguna::where('email', $payload['email'])->first();
        $this->assertNotNull($pengguna);
        $this->assertEquals('anggota', $pengguna->level_akses);

        $anggota = Anggota::where('id_pengguna', $pengguna->id_pengguna)->first();
        $this->assertNotNull($anggota);
        $this->assertEquals(4, $anggota->target_baca_bulanan);
        $this->assertEquals([$kategori1->id_kategori, $kategori2->id_kategori, $kategori3->id_kategori], $anggota->preferensi_kategori);

        $koleksi = KoleksiPribadi::where('id_pengguna', $pengguna->id_pengguna)
            ->where('id_buku', $buku1->id_buku)
            ->first();
        $this->assertNotNull($koleksi);
    }
}
