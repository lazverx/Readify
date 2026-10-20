<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\PostinganKomunitas;
use App\Models\KomentarKomunitas;
use App\Models\LikePostingan;

class KomunitasTest extends TestCase
{
    protected $anggota;
    protected $anggotaLain;
    protected $buku;

    protected function setUp(): void
    {
        parent::setUp();

        $this->anggota = Pengguna::firstOrCreate(
            ['email' => 'komunitas_test1@readify.id'],
            [
                'nama_pengguna' => 'komunitas_user1',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'anggota',
                'status' => 'active'
            ]
        );

        Anggota::firstOrCreate(
            ['id_pengguna' => $this->anggota->id_pengguna],
            [
                'nama_lengkap' => 'Penguji Komunitas Satu',
                'alamat' => 'Jl. Komunitas No. 1',
                'nomor_telepon' => '081234567891',
            ]
        );

        $this->anggotaLain = Pengguna::firstOrCreate(
            ['email' => 'komunitas_test2@readify.id'],
            [
                'nama_pengguna' => 'komunitas_user2',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'anggota',
                'status' => 'active'
            ]
        );

        Anggota::firstOrCreate(
            ['id_pengguna' => $this->anggotaLain->id_pengguna],
            [
                'nama_lengkap' => 'Penguji Komunitas Dua',
                'alamat' => 'Jl. Komunitas No. 2',
                'nomor_telepon' => '081234567892',
            ]
        );

        $this->buku = Buku::firstOrCreate(
            ['judul_buku' => 'Buku Komunitas QC Test'],
            [
                'penulis' => 'Penulis Komunitas',
                'penerbit' => 'Penerbit Komunitas',
                'tahun_terbit' => 2024,
                'isbn' => '978-9999999999',
                'stok' => 5,
                'rak' => 'Rak Komunitas',
                'sinopsis' => 'Buku untuk pengujian fitur komunitas.',
            ]
        );
    }

    /**
     * Anggota dapat melihat halaman feed komunitas
     */
    public function test_anggota_dapat_mengakses_feed_komunitas(): void
    {
        $response = $this->actingAs($this->anggota)->get(route('komunitas.index'));
        $response->assertStatus(200);
        $response->assertSee('Ruang Komunitas Literasi');
        $response->assertSee('Bagikan Ulasan, Diskusi');
    }

    /**
     * Anggota dapat membuat postingan baru di komunitas
     */
    public function test_anggota_dapat_membuat_postingan_baru(): void
    {
        $response = $this->actingAs($this->anggota)->post(route('komunitas.store'), [
            'konten' => 'Ini adalah postingan uji coba untuk testing feed komunitas Readify!',
            'tipe' => 'review',
            'rating' => 5,
            'id_buku' => $this->buku->id_buku,
        ]);

        $response->assertRedirect(route('komunitas.index'));
        $this->assertDatabaseHas('postingan_komunitas', [
            'id_pengguna' => $this->anggota->id_pengguna,
            'id_buku' => $this->buku->id_buku,
            'tipe' => 'review',
            'rating' => 5,
        ]);
    }

    /**
     * Anggota dapat mengomentari postingan anggota lain
     */
    public function test_anggota_dapat_mengomentari_postingan(): void
    {
        $post = PostinganKomunitas::create([
            'id_pengguna' => $this->anggota->id_pengguna,
            'id_buku' => $this->buku->id_buku,
            'tipe' => 'diskusi',
            'konten' => 'Postingan yang akan dikomentari oleh anggota lain.',
            'jumlah_like' => 0,
            'jumlah_komentar' => 0,
        ]);

        $response = $this->actingAs($this->anggotaLain)->post(route('komunitas.komentar.store', $post->id_postingan), [
            'konten' => 'Komentar balasan dari anggota kedua yang sangat ramah.',
        ]);

        $this->assertDatabaseHas('komentar_komunitas', [
            'id_postingan' => $post->id_postingan,
            'id_pengguna' => $this->anggotaLain->id_pengguna,
            'konten' => 'Komentar balasan dari anggota kedua yang sangat ramah.',
        ]);

        $this->assertEquals(1, $post->fresh()->jumlah_komentar);
    }

    /**
     * Anggota dapat toggle like pada postingan
     */
    public function test_anggota_dapat_toggle_like_postingan(): void
    {
        $post = PostinganKomunitas::create([
            'id_pengguna' => $this->anggota->id_pengguna,
            'tipe' => 'diskusi',
            'konten' => 'Postingan untuk pengujian toggle like AJAX.',
            'jumlah_like' => 0,
            'jumlah_komentar' => 0,
        ]);

        // Like pertama
        $response = $this->actingAs($this->anggotaLain)->postJson(route('komunitas.like', $post->id_postingan));
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'liked' => true,
            'likes_count' => 1,
        ]);
        $this->assertEquals(1, $post->fresh()->jumlah_like);

        // Unlike kedua
        $response2 = $this->actingAs($this->anggotaLain)->postJson(route('komunitas.like', $post->id_postingan));
        $response2->assertStatus(200);
        $response2->assertJson([
            'success' => true,
            'liked' => false,
            'likes_count' => 0,
        ]);
        $this->assertEquals(0, $post->fresh()->jumlah_like);
    }

    /**
     * Pemilik postingan dapat menghapus postingannya
     */
    public function test_pemilik_dapat_menghapus_postingan(): void
    {
        $post = PostinganKomunitas::create([
            'id_pengguna' => $this->anggota->id_pengguna,
            'tipe' => 'diskusi',
            'konten' => 'Postingan ini akan segera dihapus oleh pemiliknya.',
            'jumlah_like' => 0,
            'jumlah_komentar' => 0,
        ]);

        $response = $this->actingAs($this->anggota)->delete(route('komunitas.destroy', $post->id_postingan));
        $response->assertRedirect(route('komunitas.index'));

        $this->assertDatabaseMissing('postingan_komunitas', [
            'id_postingan' => $post->id_postingan,
        ]);
    }
}
