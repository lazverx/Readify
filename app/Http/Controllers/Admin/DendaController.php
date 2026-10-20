<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        // Statistik Denda Ringkasan
        $stats = [
            'total_denda' => Denda::sum('jumlah_denda') ?? 0,
            'total_belum_bayar' => Denda::where('status_pembayaran', 'belum_bayar')->sum('jumlah_denda') ?? 0,
            'count_belum_bayar' => Denda::where('status_pembayaran', 'belum_bayar')->count(),
            'total_lunas' => Denda::where('status_pembayaran', 'lunas')->sum('jumlah_denda') ?? 0,
            'count_lunas' => Denda::where('status_pembayaran', 'lunas')->count(),
        ];

        $query = Denda::with(['peminjaman.pengguna.anggota', 'peminjaman.buku', 'peminjaman.detail.buku']);

        // Search by Borrower Name or Book Title via Peminjaman
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peminjaman', function ($q) use ($search) {
                $q->whereHas('pengguna.anggota', function ($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', "%{$search}%");
                })
                    ->orWhereHas('pengguna', function ($subQ) use ($search) {
                        $subQ->where('nama_pengguna', 'like', "%{$search}%");
                    })
                    ->orWhere('kode_booking', 'like', "%{$search}%")
                    ->orWhereHas('buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    })
                    ->orWhereHas('detail.buku', function ($subQ) use ($search) {
                        $subQ->where('judul_buku', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Status Pembayaran Denda (belum_bayar / lunas)
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Filter by Peminjaman Status (Dipinjam/Telat/Dikembalikan)
        if ($request->filled('status')) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->where('status_transaksi', $request->status);
            });
        }

        // Sort
        $sort = $request->get('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('dibuat_pada', 'asc');
        } elseif ($sort === 'terbesar') {
            $query->orderBy('jumlah_denda', 'desc');
        } elseif ($sort === 'az') {
            $query->join('peminjaman', 'denda.id_peminjaman', '=', 'peminjaman.id_peminjaman')
                ->join('pengguna', 'peminjaman.id_pengguna', '=', 'pengguna.id_pengguna')
                ->leftJoin('anggota', 'pengguna.id_pengguna', '=', 'anggota.id_pengguna')
                ->select('denda.*')
                ->orderByRaw('COALESCE(anggota.nama_lengkap, pengguna.nama_pengguna) ASC');
        } else {
            $query->orderBy('dibuat_pada', 'desc');
        }

        $denda = $query->paginate(10)->withQueryString();

        return view('admin.denda.index', compact('denda', 'stats'));
    }

    public function show($id)
    {
        $denda = Denda::with(['peminjaman.pengguna.anggota', 'peminjaman.buku', 'peminjaman.detail.buku'])->findOrFail($id);
        return view('admin.denda.show', compact('denda'));
    }

    /**
     * Memproses pelunasan denda
     */
    public function bayar($id)
    {
        $denda = Denda::findOrFail($id);
        
        if ($denda->status_pembayaran === 'lunas') {
            return back()->with('error', 'Denda ini sudah berstatus lunas sebelumnya.');
        }

        $denda->update([
            'status_pembayaran' => 'lunas'
        ]);

        return back()->with('success', 'Pembayaran denda sebesar Rp ' . number_format($denda->jumlah_denda, 0, ',', '.') . ' berhasil dicatat sebagai LUNAS.');
    }
}
