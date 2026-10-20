<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\PengajuanBuku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PengajuanBukuTest extends TestCase
{
    protected $admin;
    protected $anggota;
    protected $kategori;

    protected function setUp(): void
    {
        parent::setUp();

        // Ambil atau buat akun admin
        $this->admin = Pengguna::firstOrCreate(
            ['email' => 'admin_test@readify.id'],
            [
                'nama_pengguna' => 'admin_test',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'admin',
                'status' => 'active'
            ]
        );

        // Ambil atau buat akun anggota
        $this->anggota = Pengguna::firstOrCreate(
            ['email' => 'anggota_test@readify.id'],
            [
                'nama_pengguna' => 'anggota_test',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'anggota',
                'status' => 'active'
            ]
        );

        // Kategori
        $this->kategori = Kategori::firstOrCreate(['nama_kategori' => 'Teknologi']);
    }

    /**
     * Test Anggota Mengajukan Usulan Buku Baru
     */
    public function test_anggota_dapat_mengajukan_usulan_buku_dan_notif_ke_admin(): void
    {
        $response = $this->actingAs($this->anggota)->post(route('pengajuan-buku.store'), [
            'judul_buku' => 'Designing Data-Intensive Applications',
            'nama_penulis' => 'Martin Kleppmann',
            'isbn' => '978-1449373320',
            'penerbit' => "O'Reilly Media",
            'tahun_terbit' => 2017,
            'kategori' => 'Teknologi',
            'nama_pengusul' => 'Anggota Test Readify',
            'alasan_pengusulan' => 'Buku ini sangat penting untuk mempelajari sistem terdistribusi dan arsitektur database modern.',
        ]);

        $response->assertStatus(302);

        // Verifikasi pengajuan tersimpan di database
        $this->assertDatabaseHas('pengajuan_buku', [
            'judul_buku' => 'Designing Data-Intensive Applications',
            'nama_penulis' => 'Martin Kleppmann',
            'status' => 'menunggu',
            'id_pengguna' => $this->anggota->id_pengguna,
        ]);

        $pengajuan = PengajuanBuku::where('judul_buku', 'Designing Data-Intensive Applications')->first();

        // Verifikasi notifikasi terkirim ke admin
        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $this->admin->id_pengguna,
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'tipe' => 'pengajuan_baru',
            'sudah_dibaca' => false,
        ]);
    }

    /**
     * Test Admin Melakukan ACC & Terbitkan Buku ke Katalog
     */
    public function test_admin_dapat_acc_dan_terbitkan_buku_ke_katalog(): void
    {
        Storage::fake('public');

        // Buat pengajuan dummy
        $pengajuan = PengajuanBuku::create([
            'judul_buku' => 'Domain-Driven Design',
            'nama_penulis' => 'Eric Evans',
            'isbn' => '9780321125217',
            'penerbit' => 'Addison-Wesley',
            'tahun_terbit' => 2003,
            'kategori' => 'Teknologi',
            'id_pengguna' => $this->anggota->id_pengguna,
            'nama_pengusul' => 'Anggota Test',
            'alasan_pengusulan' => 'Buku fundamental untuk software architecture dan microservices pattern.',
            'status' => 'menunggu',
        ]);

        $dummyCover = UploadedFile::fake()->create('ddd_cover.jpg', 100, 'image/jpeg');

        // Admin melakukan ACC & Publish
        $response = $this->actingAs($this->admin)->post(route('admin.pengajuan-buku.acc', $pengajuan->id_pengajuan), [
            'judul_buku' => 'Domain-Driven Design: Tackling Complexity in the Heart of Software',
            'penulis' => 'Eric Evans',
            'isbn' => '9780321125217',
            'penerbit' => 'Addison-Wesley Professional',
            'tahun_terbit' => 2003,
            'stok' => 7,
            'jumlah_halaman' => 560,
            'bahasa' => 'en',
            'lokasi_rak' => 'Rak T-05',
            'sinopsis' => 'Buku standar industri software design berorientasi domain bisnis.',
            'kategori' => [$this->kategori->id_kategori],
            'sampul' => $dummyCover,
            'catatan_admin' => 'Usulan buku disetujui, buku telah tersedia di Rak T-05.',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.pengajuan-buku.show', $pengajuan->id_pengajuan));

        $pengajuan->refresh();
        $this->assertEquals('disetujui', $pengajuan->status);
        $this->assertNotNull($pengajuan->id_buku);

        $buku = Buku::find($pengajuan->id_buku);
        $this->assertNotNull($buku);
        $this->assertEquals('Domain-Driven Design: Tackling Complexity in the Heart of Software', $buku->judul_buku);
        $this->assertTrue($buku->kategori->contains('id_kategori', $this->kategori->id_kategori));

        // 3. Notifikasi sukses terkirim ke anggota
        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $this->anggota->id_pengguna,
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'tipe' => 'status_pengajuan',
        ]);
    }

    /**
     * Test Admin Dapat Menolak Pengajuan Buku dengan Catatan Alasan
     */
    public function test_admin_dapat_menolak_pengajuan_buku(): void
    {
        $pengajuan = PengajuanBuku::create([
            'judul_buku' => 'Buku yang Ditolak',
            'nama_penulis' => 'Penulis Random',
            'id_pengguna' => $this->anggota->id_pengguna,
            'nama_pengusul' => 'Anggota Test',
            'alasan_pengusulan' => 'Hanya ingin mengusulkan buku ini untuk perpustakaan.',
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.pengajuan-buku.status', $pengajuan->id_pengajuan), [
            'status' => 'ditolak',
            'catatan_admin' => 'Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.',
        ]);

        $response->assertStatus(302);

        $pengajuan->refresh();
        $this->assertEquals('ditolak', $pengajuan->status);
        $this->assertEquals('Buku dengan tema ini sudah memiliki 3 judul serupa di perpustakaan.', $pengajuan->catatan_admin);

        // Notifikasi penolakan ke anggota
        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $this->anggota->id_pengguna,
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'tipe' => 'status_pengajuan',
        ]);
    }
}
