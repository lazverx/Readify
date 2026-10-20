<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Pengguna;

class PenggunaTest extends TestCase
{
    /**
     * Test pengecekan role administrator
     */
    public function test_user_is_admin(): void
    {
        $admin = new Pengguna(['level_akses' => 'admin']);
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isPetugas());
        $this->assertFalse($admin->isAnggota());
    }

    /**
     * Test pengecekan role petugas
     */
    public function test_user_is_petugas(): void
    {
        $petugas = new Pengguna(['level_akses' => 'petugas']);
        $this->assertTrue($petugas->isPetugas());
        $this->assertFalse($petugas->isAdmin());
        $this->assertTrue($petugas->isUser());
    }

    /**
     * Test pengecekan role anggota
     */
    public function test_user_is_anggota(): void
    {
        $anggota = new Pengguna(['level_akses' => 'anggota']);
        $this->assertTrue($anggota->isAnggota());
        $this->assertFalse($anggota->isAdmin());
        $this->assertTrue($anggota->isUser());
    }

    /**
     * Test pengecekan status verifikasi anggota
     */
    public function test_status_verifikasi(): void
    {
        $pending = new Pengguna(['status' => 'pending']);
        $this->assertTrue($pending->isPending());

        $active = new Pengguna(['status' => 'active']);
        $this->assertTrue($active->isActive());

        $rejected = new Pengguna(['status' => 'rejected']);
        $this->assertTrue($rejected->isRejected());
    }

    /**
     * Test admin selalu memiliki izin akses ke semua fitur
     */
    public function test_admin_can_access_any_feature(): void
    {
        $admin = new Pengguna(['level_akses' => 'admin']);
        $this->assertTrue($admin->canAccess('buku'));
        $this->assertTrue($admin->canAccess('kategori'));
        $this->assertTrue($admin->canAccess('laporan'));
        $this->assertTrue($admin->canAccess('denda'));
    }

    /**
     * Test format nomor anggota yang digenerate sistem
     */
    public function test_format_nomor_anggota(): void
    {
        $tahun = date('Y');
        $nomor = Pengguna::generateNomorAnggota();

        $this->assertIsString($nomor);
        $this->assertStringStartsWith('ID-', $nomor);
        $this->assertStringEndsWith("-PX-{$tahun}", $nomor);
    }
}
