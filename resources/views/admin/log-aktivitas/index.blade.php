@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">
                <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <svg class="h-6 w-6 text-[#004236]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Log Aktivitas & Audit Trail
            </h2>
            <p class="text-sm text-gray-500 mt-1">Rekam jejak seluruh operasi, transaksi, dan perubahan data dalam sistem</p>
        </div>

        {{-- Action: Pembersihan Log --}}
        <div x-data="{ openPurge: false }">
            <button type="button" @click="openPurge = true"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition">
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Pembersihan Log
            </button>

            {{-- Modal Purge --}}
            <div x-show="openPurge" x-cloak style="display: none;"
                class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
                <div @click.outside="openPurge = false"
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bersihkan Log Lama</h3>
                    <p class="text-sm text-gray-500 mb-4">Hapus riwayat log yang sudah lama untuk menghemat kapasitas database.</p>
                    <form action="{{ route('admin.log-aktivitas.clear') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Hapus log lebih lama dari:</label>
                            <select name="days" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm">
                                <option value="7">7 Hari yang lalu</option>
                                <option value="30" selected>30 Hari yang lalu</option>
                                <option value="60">60 Hari yang lalu</option>
                                <option value="90">90 Hari yang lalu</option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="openPurge = false"
                                class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                Bersihkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xs">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Aktivitas</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_logs']) }}</span>
                <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Semua</span>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xs">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Aktivitas Hari Ini</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-emerald-700">{{ number_format($stats['today_logs']) }}</span>
                <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">Hari Ini</span>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xs">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Aksi Admin</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-purple-700">{{ number_format($stats['admin_actions']) }}</span>
                <span class="text-xs font-semibold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full">Admin</span>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xs">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Aksi Petugas</span>
            <div class="mt-2 flex items-baseline justify-between">
                <span class="text-2xl font-bold text-blue-700">{{ number_format($stats['petugas_actions']) }}</span>
                <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full">Petugas</span>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-xs mb-6">
        <form method="GET" action="{{ route('admin.log-aktivitas.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            {{-- Search Keyword --}}
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Cari Keyword</label>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari deskripsi, nama pengguna, IP..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3.5 py-2 text-sm focus:bg-white focus:border-[#004236] outline-none">
            </div>

            {{-- Filter Role --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Role Pengguna</label>
                <select name="role" class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:bg-white outline-none">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="anggota" {{ request('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                </select>
            </div>

            {{-- Filter Aksi --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Kategori Aksi</label>
                <select name="aksi" class="w-full rounded-xl border border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:bg-white outline-none">
                    <option value="">Semua Aksi</option>
                    @foreach($availableActions as $act)
                        <option value="{{ $act }}" {{ request('aksi') === $act ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $act)) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-end gap-2">
                <button type="submit"
                    class="flex-1 rounded-xl bg-[#004236] px-4 py-2 text-sm font-semibold text-white hover:bg-[#00342b] transition">
                    Filter
                </button>
                <a href="{{ route('admin.log-aktivitas.index') }}"
                    class="rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition"
                    title="Reset Filter">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table of Logs --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50/75 text-xs font-bold uppercase tracking-wider text-gray-500">
                        <th class="px-5 py-3.5">Waktu</th>
                        <th class="px-5 py-3.5">Pengguna & Role</th>
                        <th class="px-5 py-3.5">Aksi</th>
                        <th class="px-5 py-3.5">Deskripsi Aktivitas</th>
                        <th class="px-5 py-3.5">IP & Perangkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition">
                            {{-- Waktu --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $log->dibuat_pada->format('d M Y, H:i') }}</div>
                                <div class="text-[11px] text-gray-400">{{ $log->dibuat_pada->diffForHumans() }}</div>
                            </td>

                            {{-- Pengguna & Role --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="font-semibold text-gray-900">{{ $log->nama_pengguna }}</div>
                                @if($log->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                                        ADMIN
                                    </span>
                                @elseif($log->role === 'petugas')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                        PETUGAS
                                    </span>
                                @elseif($log->role === 'anggota')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        ANGGOTA
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700">
                                        {{ strtoupper($log->role) }}
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-700">
                                    {{ ucwords(str_replace('_', ' ', $log->aksi)) }}
                                </span>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-5 py-3.5 text-gray-700">
                                <p class="leading-relaxed line-clamp-2" title="{{ $log->deskripsi }}">
                                    {{ $log->deskripsi }}
                                </p>
                            </td>

                            {{-- IP & Perangkat --}}
                            <td class="px-5 py-3.5 whitespace-nowrap text-xs text-gray-500">
                                <div class="font-mono text-gray-700">{{ $log->ip_address ?: '127.0.0.1' }}</div>
                                <div class="text-[11px] text-gray-400 truncate max-w-[180px]" title="{{ $log->user_agent }}">
                                    {{ Str::limit($log->user_agent, 25) }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400 mb-3">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="font-semibold text-gray-600">Belum ada catatan log aktivitas</p>
                                <p class="text-xs text-gray-400 mt-1">Aktivitas sistem akan otomatis tercatat di sini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
