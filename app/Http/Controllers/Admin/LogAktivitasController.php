<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('pengguna')->latest('dibuat_pada');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('deskripsi', 'like', "%{$q}%")
                    ->orWhere('nama_pengguna', 'like', "%{$q}%")
                    ->orWhere('aksi', 'like', "%{$q}%")
                    ->orWhere('ip_address', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        if ($request->filled('tgl_mulai')) {
            $query->whereDate('dibuat_pada', '>=', $request->tgl_mulai);
        }

        if ($request->filled('tgl_selesai')) {
            $query->whereDate('dibuat_pada', '<=', $request->tgl_selesai);
        }

        $logs = $query->paginate(20)->withQueryString();

        $stats = [
            'total_logs' => LogAktivitas::count(),
            'today_logs' => LogAktivitas::whereDate('dibuat_pada', today())->count(),
            'admin_actions' => LogAktivitas::where('role', 'admin')->count(),
            'petugas_actions' => LogAktivitas::where('role', 'petugas')->count(),
        ];

        // Daftar aksi unik untuk dropdown filter
        $availableActions = LogAktivitas::select('aksi')->distinct()->pluck('aksi');

        return view('admin.log-aktivitas.index', compact('logs', 'stats', 'availableActions'));
    }

    public function clearOld(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $deleted = LogAktivitas::where('dibuat_pada', '<', now()->subDays($days))->delete();

        LogAktivitas::catat('pembersihan_log', "Admin membersihkan {$deleted} log aktivitas yang lebih lama dari {$days} hari.");

        return redirect()->route('admin.log-aktivitas.index')
            ->with('success', "Berhasil membersihkan {$deleted} data log yang lebih lama dari {$days} hari.");
    }
}
