<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Models\Ulasan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GamifikasiService
{
    /**
     * Dapatkan Leaderboard Top Pembaca (berdasarkan total buku yang dipinjam)
     */
    public static function getLeaderboard(int $limit = 5): array
    {
        $topBorrowers = Peminjaman::select('id_pengguna', DB::raw('COUNT(*) as total_pinjam'))
            ->whereIn('status_transaksi', ['dipinjam', 'dikembalikan', 'terlambat'])
            ->groupBy('id_pengguna')
            ->orderByDesc('total_pinjam')
            ->limit($limit)
            ->get();

        $leaderboard = [];
        $rank = 1;

        foreach ($topBorrowers as $item) {
            $user = Pengguna::with('anggota')->find($item->id_pengguna);
            if (!$user) {
                continue;
            }

            $nama = $user->anggota->nama_lengkap ?? $user->nama_pengguna;
            $foto = $user->foto_profil ? asset('storage/foto_profil/' . $user->foto_profil) : null;
            $initials = strtoupper(substr($nama, 0, 2));

            $leaderboard[] = [
                'rank' => $rank,
                'id_pengguna' => $user->id_pengguna,
                'nama' => $nama,
                'foto' => $foto,
                'initials' => $initials,
                'total_pinjam' => (int) $item->total_pinjam,
                'badge_title' => match (true) {
                    $item->total_pinjam >= 10 => 'Master Pustaka',
                    $item->total_pinjam >= 5 => 'Penjelajah Literasi',
                    default => 'Pembaca Aktif',
                },
            ];

            $rank++;
        }

        return $leaderboard;
    }

    /**
     * Dapatkan status dan peringkat pengguna saat ini
     */
    public static function getUserStats(int $idPengguna): array
    {
        $totalPinjam = Peminjaman::where('id_pengguna', $idPengguna)
            ->whereIn('status_transaksi', ['dipinjam', 'dikembalikan', 'terlambat'])
            ->count();

        $totalSelesai = Peminjaman::where('id_pengguna', $idPengguna)
            ->where('status_transaksi', 'dikembalikan')
            ->count();

        $totalUlasan = Ulasan::where('id_pengguna', $idPengguna)->count();

        $pinjamanTepatWaktu = Peminjaman::where('id_pengguna', $idPengguna)
            ->where('status_transaksi', 'dikembalikan')
            ->where(function ($q) {
                $q->whereDoesntHave('denda')
                  ->orWhereHas('denda', function ($d) {
                      $d->where('jumlah_denda', '<=', 0);
                  });
            })
            ->count();

        // Hitung peringkat di antara seluruh anggota
        $subquery = Peminjaman::select('id_pengguna', DB::raw('COUNT(*) as total'))
            ->whereIn('status_transaksi', ['dipinjam', 'dikembalikan', 'terlambat'])
            ->groupBy('id_pengguna')
            ->having('total', '>', $totalPinjam)
            ->get();

        $userRank = $subquery->count() + 1;

        return [
            'total_pinjam' => $totalPinjam,
            'total_selesai' => $totalSelesai,
            'total_ulasan' => $totalUlasan,
            'pinjaman_tepat_waktu' => $pinjamanTepatWaktu,
            'rank' => $totalPinjam > 0 ? $userRank : '-',
        ];
    }

    /**
     * Dapatkan semua lencana (badges) beserta status pencapaian untuk pengguna tertentu
     */
    public static function getUserBadges(int $idPengguna): array
    {
        $stats = self::getUserStats($idPengguna);
        $totalPinjam = $stats['total_pinjam'];
        $totalSelesai = $stats['total_selesai'];
        $totalUlasan = $stats['total_ulasan'];
        $tepatWaktu = $stats['pinjaman_tepat_waktu'];

        // Hitung manga yang pernah dipinjam
        $mangaCount = Peminjaman::where('id_pengguna', $idPengguna)
            ->whereIn('status_transaksi', ['dipinjam', 'dikembalikan', 'terlambat'])
            ->whereHas('buku.kategori', function ($q) {
                $q->where('nama_kategori', 'like', '%manga%')
                  ->orWhere('nama_kategori', 'like', '%komik%');
            })
            ->count();

        // Hitung buku teknologi/sains yang pernah dipinjam
        $techCount = Peminjaman::where('id_pengguna', $idPengguna)
            ->whereIn('status_transaksi', ['dipinjam', 'dikembalikan', 'terlambat'])
            ->whereHas('buku.kategori', function ($q) {
                $q->where('nama_kategori', 'like', '%teknologi%')
                  ->orWhere('nama_kategori', 'like', '%sains%');
            })
            ->count();

        $badges = [
            [
                'id' => 'kutu_buku_pemula',
                'nama' => 'Langkah Awal',
                'deskripsi' => 'Meminjam minimal 1 buku dari perpustakaan.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>',
                'bg_gradient' => 'from-emerald-500 to-teal-600',
                'border_color' => 'border-emerald-500',
                'tercapai' => $totalPinjam >= 1,
                'progres' => min($totalPinjam, 1) . ' / 1',
                'persen' => min(100, (int)(($totalPinjam / 1) * 100)),
            ],
            [
                'id' => 'penjelajah_literasi',
                'nama' => 'Penjelajah Literasi',
                'deskripsi' => 'Telah meminjam minimal 5 buku.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" /></svg>',
                'bg_gradient' => 'from-blue-500 to-indigo-600',
                'border_color' => 'border-blue-500',
                'tercapai' => $totalPinjam >= 5,
                'progres' => min($totalPinjam, 5) . ' / 5',
                'persen' => min(100, (int)(($totalPinjam / 5) * 100)),
            ],
            [
                'id' => 'master_pustaka',
                'nama' => 'Master Pustaka',
                'deskripsi' => 'Kolektor bacaan sejati: pinjam minimal 10 buku!',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>',
                'bg_gradient' => 'from-amber-400 to-orange-500',
                'border_color' => 'border-amber-500',
                'tercapai' => $totalPinjam >= 10,
                'progres' => min($totalPinjam, 10) . ' / 10',
                'persen' => min(100, (int)(($totalPinjam / 10) * 100)),
            ],
            [
                'id' => 'manga_enthusiast',
                'nama' => 'Manga Explorer',
                'deskripsi' => 'Meminjam minimal 2 serial manga atau komik.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" /></svg>',
                'bg_gradient' => 'from-rose-500 to-pink-600',
                'border_color' => 'border-rose-500',
                'tercapai' => $mangaCount >= 2,
                'progres' => min($mangaCount, 2) . ' / 2',
                'persen' => min(100, (int)(($mangaCount / 2) * 100)),
            ],
            [
                'id' => 'tech_savvy',
                'nama' => 'Tech Pioneer',
                'deskripsi' => 'Meminjam minimal 2 buku kategori Sains atau Teknologi.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',
                'bg_gradient' => 'from-cyan-500 to-blue-600',
                'border_color' => 'border-cyan-500',
                'tercapai' => $techCount >= 2,
                'progres' => min($techCount, 2) . ' / 2',
                'persen' => min(100, (int)(($techCount / 2) * 100)),
            ],
            [
                'id' => 'kritikus_teladan',
                'nama' => 'Kritikus Handal',
                'deskripsi' => 'Membantu pembaca lain dengan menuliskan minimal 2 ulasan.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>',
                'bg_gradient' => 'from-purple-500 to-violet-600',
                'border_color' => 'border-purple-500',
                'tercapai' => $totalUlasan >= 2,
                'progres' => min($totalUlasan, 2) . ' / 2',
                'persen' => min(100, (int)(($totalUlasan / 2) * 100)),
            ],
            [
                'id' => 'disiplin_waktu',
                'nama' => 'Disiplin Waktu',
                'deskripsi' => 'Menyelesaikan minimal 3 pengembalian tepat waktu tanpa denda.',
                'icon' => '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                'bg_gradient' => 'from-emerald-400 to-green-600',
                'border_color' => 'border-emerald-500',
                'tercapai' => $tepatWaktu >= 3,
                'progres' => min($tepatWaktu, 3) . ' / 3',
                'persen' => min(100, (int)(($tepatWaktu / 3) * 100)),
            ],
        ];

        return $badges;
    }
}
