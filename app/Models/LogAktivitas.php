<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_pengguna',
        'nama_pengguna',
        'role',
        'aksi',
        'deskripsi',
        'ip_address',
        'user_agent',
        'dibuat_pada',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    /**
     * Helper praktis untuk mencatat log aktivitas
     */
    public static function catat(string $aksi, string $deskripsi, ?int $idPengguna = null, ?string $role = null): ?self
    {
        try {
            $user = auth()->user();
            $userId = $idPengguna ?? ($user ? $user->id_pengguna : null);
            $userName = $user ? $user->nama_pengguna : 'Sistem / Tamu';
            $userRole = $role ?? ($user ? $user->level_akses : 'tamu');

            return self::create([
                'id_pengguna' => $userId,
                'nama_pengguna' => $userName,
                'role' => $userRole,
                'aksi' => $aksi,
                'deskripsi' => $deskripsi,
                'ip_address' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 250),
                'dibuat_pada' => now(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Gagal mencatat log aktivitas: " . $e->getMessage());
            return null;
        }
    }
}
