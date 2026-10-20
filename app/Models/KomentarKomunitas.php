<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class KomentarKomunitas extends Model
{
    protected $table = 'komentar_komunitas';
    protected $primaryKey = 'id_komentar';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'id_postingan',
        'id_pengguna',
        'konten',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    public function postingan()
    {
        return $this->belongsTo(PostinganKomunitas::class, 'id_postingan', 'id_postingan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    public function getWaktuLaluAttribute(): string
    {
        return $this->dibuat_pada ? Carbon::parse($this->dibuat_pada)->locale('id')->diffForHumans() : 'baru saja';
    }
}
