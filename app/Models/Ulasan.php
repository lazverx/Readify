<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    public $timestamps = true;

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diperbarui_pada';

    protected $fillable = [
        'id_buku',
        'id_pengguna',
        'rating',
        'isi_ulasan',
    ];

    protected $casts = [
        'rating' => 'integer',
        'dibuat_pada' => 'datetime',
        'diperbarui_pada' => 'datetime',
    ];

    /**
     * Relasi ke Buku
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    /**
     * Relasi ke Pengguna (yang menulis ulasan)
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Relasi ke Anggota (detail profil anggota)
     */
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Scope untuk mendapatkan rating rata-rata
     */
    public function scopeRatingRataRata($query, $idBuku)
    {
        return $query->where('id_buku', $idBuku)->avg('rating');
    }

    /**
     * Scope untuk mengurutkan terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('dibuat_pada', 'desc');
    }
}
