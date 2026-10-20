<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = true;

    protected $fillable = [
        'id_pengguna',
        'tipe',
        'judul',
        'pesan',
        'id_pengajuan',
        'id_peminjaman',
        'link',
        'sudah_dibaca',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
    ];

    /**
     * Relasi ke pengguna (penerima notifikasi)
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
    }

    /**
     * Relasi ke pengajuan buku
     */
    public function pengajuanBuku()
    {
        return $this->belongsTo(PengajuanBuku::class, 'id_pengajuan', 'id_pengajuan');
    }

    /**
     * Relasi ke peminjaman buku
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Helper membuat notifikasi pengingat jatuh tempo otomatis
     */
    public static function kirimPengingatJatuhTempo(Peminjaman $peminjaman, int $sisaHari): ?self
    {
        // Cegah notifikasi ganda pada hari yang sama untuk transaksi ini
        $alreadySentToday = self::where('id_pengguna', $peminjaman->id_pengguna)
            ->where('id_peminjaman', $peminjaman->id_peminjaman)
            ->where('tipe', 'jatuh_tempo')
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadySentToday) {
            return null;
        }

        $judulBuku = $peminjaman->buku->judul_buku ?? 'Buku Perpustakaan';
        $tglTempo = $peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d M Y') : 'segera';

        if ($sisaHari > 0) {
            $pesan = "Pengingat: Peminjaman buku '{$judulBuku}' akan jatuh tempo dalam {$sisaHari} hari lagi ({$tglTempo}). Segera kembalikan atau lakukan perpanjangan untuk menghindari denda Rp 1.000/hari.";
            $judul = "Pengingat Jatuh Tempo (H-{$sisaHari})";
        } else {
            $hariTelat = abs($sisaHari);
            $pesan = "Peringatan: Peminjaman buku '{$judulBuku}' telah melewati batas jatuh tempo ({$hariTelat} hari terlambat). Denda berjalan Rp 1.000/hari. Harap segera kembalikan ke perpustakaan.";
            $judul = "Peringatan Keterlambatan Buku";
        }

        return self::create([
            'id_pengguna' => $peminjaman->id_pengguna,
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'tipe' => 'jatuh_tempo',
            'judul' => $judul,
            'pesan' => $pesan,
            'link' => route('anggota.pinjaman'),
            'sudah_dibaca' => false,
        ]);
    }

    /**
     * Scope notifikasi belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    /**
     * Icon berdasarkan tipe
     */
    public function getIconAttribute(): string
    {
        return match ($this->tipe) {
            'pengajuan_baru' => 'book-open',
            'status_pengajuan' => 'check-circle',
            default => 'bell',
        };
    }

    /**
     * Warna berdasarkan tipe dan konten pesan
     */
    public function getWarnaBadgeAttribute(): string
    {
        if ($this->tipe === 'pengajuan_baru') {
            return 'blue';
        }
        if (str_contains($this->pesan, 'disetujui')) {
            return 'green';
        }
        if (str_contains($this->pesan, 'ditolak')) {
            return 'red';
        }
        return 'yellow';
    }
}
