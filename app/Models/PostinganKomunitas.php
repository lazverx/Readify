<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PostinganKomunitas extends Model
{
    protected $table = 'postingan_komunitas';
    protected $primaryKey = 'id_postingan';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'id_pengguna',
        'id_buku',
        'tipe',
        'rating',
        'konten',
        'jumlah_like',
        'jumlah_komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
        'jumlah_like' => 'integer',
        'jumlah_komentar' => 'integer',
        'dibuat_pada' => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    /**
     * Relasi ke pembuat postingan
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Relasi ke buku yang ditautkan (opsional)
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    /**
     * Relasi ke komentar
     */
    public function komentar()
    {
        return $this->hasMany(KomentarKomunitas::class, 'id_postingan', 'id_postingan')
            ->orderBy('dibuat_pada', 'asc');
    }

    /**
     * Relasi ke likes
     */
    public function likes()
    {
        return $this->hasMany(LikePostingan::class, 'id_postingan', 'id_postingan');
    }

    /**
     * Cek apakah postingan sudah disukai oleh pengguna tertentu
     */
    public function sudahDiLike(?int $idPengguna): bool
    {
        if (!$idPengguna) {
            return false;
        }

        return $this->likes()->where('id_pengguna', $idPengguna)->exists();
    }

    /**
     * Label dan styling badge tipe postingan
     */
    public function getBadgeTipeAttribute(): array
    {
        return match ($this->tipe) {
            'review' => [
                'label' => '⭐ Review Buku',
                'class' => 'bg-amber-100 text-amber-800 border-amber-200',
            ],
            'kutipan' => [
                'label' => '💡 Kutipan Favorit',
                'class' => 'bg-purple-100 text-purple-800 border-purple-200',
            ],
            'rekomendasi' => [
                'label' => '📚 Rekomendasi',
                'class' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            ],
            default => [
                'label' => '💬 Diskusi',
                'class' => 'bg-blue-100 text-blue-800 border-blue-200',
            ],
        };
    }

    /**
     * Format waktu relatif bahasa Indonesia
     */
    public function getWaktuLaluAttribute(): string
    {
        return $this->dibuat_pada ? Carbon::parse($this->dibuat_pada)->locale('id')->diffForHumans() : 'baru saja';
    }
}
