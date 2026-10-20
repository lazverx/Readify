<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\Pengguna;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\LogAktivitas;
use App\Services\DueNotificationService;
use App\Services\GamifikasiService;
use Carbon\Carbon;

class NewFeaturesBatchTest extends TestCase
{
    protected $admin;
    protected $anggota;
    protected $buku;
    protected $peminjaman;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::firstOrCreate(
            ['email' => 'admin_test@readify.id'],
            [
                'nama_pengguna' => 'admin_test',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'admin',
                'status' => 'active'
            ]
        );

        $this->anggota = Pengguna::firstOrCreate(
            ['email' => 'anggota_test@readify.id'],
            [
                'nama_pengguna' => 'anggota_test',
                'kata_sandi' => bcrypt('password'),
                'level_akses' => 'anggota',
                'status' => 'active'
            ]
        );

        // Pastikan record Anggota ada
        Anggota::firstOrCreate(
            ['id_pengguna' => $this->anggota->id_pengguna],
            [
                'id_anggota' => 'ANG-9999',
                'nama_lengkap' => 'Anggota Test Pengujian',
                'alamat' => 'Jl. Pengujian No. 123',
                'no_telp' => '081234567890',
            ]
        );

        $this->buku = Buku::firstOrCreate(
            ['judul_buku' => 'Test Buku QC Automated'],
            [
                'penulis' => 'Penulis QC',
                'penerbit' => 'Penerbit QC',
                'tahun_terbit' => 2024,
                'isbn' => '978-0000000001',
                'stok' => 5,
                'rak' => 'Rak A1',
                'sinopsis' => 'Buku ini dibuat untuk pengujian otomatis unit dan feature.',
            ]
        );

        $this->peminjaman = Peminjaman::firstOrCreate(
            ['kode_booking' => 'BKQC9999'],
            [
                'id_pengguna' => $this->anggota->id_pengguna,
                'id_buku' => $this->buku->id_buku,
                'tgl_booking' => Carbon::today(),
                'tgl_pinjam' => Carbon::today(),
                'durasi_pinjam' => 7,
                'tgl_jatuh_tempo' => Carbon::today()->addDays(2), // H-2
                'status_transaksi' => 'dipinjam',
            ]
        );
    }

    /**
     * Feature 7: Log Aktivitas tercatat dan halaman audit trail admin dapat diakses
     */
    public function test_log_aktivitas_tercatat_dan_admin_dapat_melihat(): void
    {
        LogAktivitas::catat('login', 'Admin login ke sistem untuk uji coba', $this->admin->id_pengguna);

        $this->assertDatabaseHas('log_aktivitas', [
            'id_pengguna' => $this->admin->id_pengguna,
            'aksi' => 'login',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.log-aktivitas.index'));
        $response->assertStatus(200);
        $response->assertSee('Log Aktivitas');
        $response->assertSee('Audit Trail');
    }

    /**
     * Feature 2: Cetak Struk Peminjaman & Denda dapat diakses oleh anggota peminjam
     */
    public function test_anggota_dapat_melihat_struk_transaksi_miliknya(): void
    {
        $response = $this->actingAs($this->anggota)->get(route('peminjaman.struk', $this->peminjaman->id_peminjaman));
        $response->assertStatus(200);
        $response->assertSee('READIFY LIBRARY');
        $response->assertSee('DETAIL SIRKULASI BUKU');
        $response->assertSee($this->peminjaman->kode_booking);
        $response->assertSee($this->buku->judul_buku);
    }

    /**
     * Feature 3: Pengingat Jatuh Tempo mendeteksi pinjaman H-2 dan membuat notifikasi
     */
    public function test_due_notification_service_dan_artisan_command(): void
    {
        // Bersihkan notifikasi uji coba sebelumnya agar tidak terhalang duplicate check
        Notifikasi::where('id_peminjaman', $this->peminjaman->id_peminjaman)->delete();

        // Pastikan pinjaman H-1
        $this->peminjaman->update([
            'status_transaksi' => 'dipinjam',
            'tgl_jatuh_tempo' => Carbon::today()->addDays(1), // H-1
        ]);

        $notifCount = DueNotificationService::checkDueDates($this->anggota->id_pengguna);
        $this->assertGreaterThanOrEqual(1, $notifCount);

        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $this->anggota->id_pengguna,
            'id_peminjaman' => $this->peminjaman->id_peminjaman,
            'tipe' => 'jatuh_tempo',
        ]);

        // Uji command artisan
        $this->artisan('peminjaman:cek-jatuh-tempo', ['--user' => $this->anggota->id_pengguna])
            ->assertExitCode(0);
    }

    /**
     * Feature 4: Gamifikasi Leaderboard dan Lencana pembaca
     */
    public function test_gamifikasi_service_menghitung_leaderboard_dan_lencana(): void
    {
        $leaderboard = GamifikasiService::getLeaderboard(5);
        $this->assertIsArray($leaderboard);

        $badges = GamifikasiService::getUserBadges($this->anggota->id_pengguna);
        $this->assertIsArray($badges);
        $this->assertNotEmpty($badges);

        // Langkah awal tercapai karena ada pinjaman
        $badgeLangkahAwal = collect($badges)->firstWhere('id', 'kutu_buku_pemula');
        $this->assertNotNull($badgeLangkahAwal);
        $this->assertTrue($badgeLangkahAwal['tercapai']);

        // Profile view menampilkan lencana
        $response = $this->actingAs($this->anggota)->get(route('anggota.profile'));
        $response->assertStatus(200);
        $response->assertSee('Lencana');
        $response->assertSee('Prestasi Literasi');
    }

    /**
     * Feature 6: Live Search AJAX dan Quick Preview endpoint
     */
    public function test_live_search_ajax_dan_quick_preview_modal(): void
    {
        // Quick Preview JSON endpoint
        $previewResponse = $this->actingAs($this->anggota)
            ->getJson(route('anggota.buku.quick-preview', $this->buku->id_buku));

        $previewResponse->assertStatus(200);
        $previewResponse->assertJsonFragment([
            'id_buku' => $this->buku->id_buku,
            'judul_buku' => $this->buku->judul_buku,
        ]);

        // Live Search AJAX
        $searchResponse = $this->actingAs($this->anggota)
            ->getJson(route('anggota.dashboard', ['search' => 'QC Automated', 'ajax' => 1]));

        $searchResponse->assertStatus(200);
        $searchResponse->assertJsonStructure(['html', 'pagination', 'total']);
        $this->assertStringContainsString('Test Buku QC Automated', $searchResponse->json('html'));
    }
}
