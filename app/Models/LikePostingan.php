<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikePostingan extends Model
{
    protected $table = 'like_postingan';
    protected $primaryKey = 'id_like';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = null; // Tidak ada updated_at di tabel like

    protected $fillable = [
        'id_postingan',
        'id_pengguna',
    ];

    public function postingan()
    {
        return $this->belongsTo(PostinganKomunitas::class, 'id_postingan', 'id_postingan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
