@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <!-- Header Section -->
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Kelola Data Denda
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pantau dan kelola denda keterlambatan pengembalian buku</p>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 shadow-sm dark:bg-green-900/20 dark:border-green-800">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="text-sm font-medium text-green-800 dark:text-green-300">
                    {!! session('success') !!}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm dark:bg-red-900/20 dark:border-red-800">
                <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500 text-white">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div class="text-sm font-medium text-red-800 dark:text-red-300">
                    {!! session('error') !!}
                </div>
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <!-- Total Denda -->
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Denda Tercatat</p>
                        <h4 class="mt-2 text-2xl font-bold text-black dark:text-white">
                            Rp {{ number_format($stats['total_denda'] ?? 0, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 dark:bg-purple-900/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Belum Dibayar -->
            <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-red-500">Belum Dibayar</p>
                        <h4 class="mt-2 text-2xl font-bold text-red-600 dark:text-red-400">
                            Rp {{ number_format($stats['total_belum_bayar'] ?? 0, 0, ',', '.') }}
                        </h4>
                        <span class="text-xs text-gray-500">{{ $stats['count_belum_bayar'] ?? 0 }} transaksi tertunggak</span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600 dark:bg-red-900/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sudah Lunas -->
            <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-green-600">Sudah Lunas</p>
                        <h4 class="mt-2 text-2xl font-bold text-green-600 dark:text-green-400">
                            Rp {{ number_format($stats['total_lunas'] ?? 0, 0, ',', '.') }}
                        </h4>
                        <span class="text-xs text-gray-500">{{ $stats['count_lunas'] ?? 0 }} transaksi selesai</span>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-900/30">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Card -->
        <div class="rounded-[20px] border border-gray-100 bg-white px-5 pb-5 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 xl:pb-6">
            <form method="GET" action="{{ route('admin.denda.index') }}"
                class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center">

                <!-- Search Bar -->
                <div class="relative flex-1">
                    <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="fill-current text-gray-400 dark:text-gray-300" width="18" height="18" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z" />
                        </svg>
                    </button>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari peminjam, judul buku, atau kode booking..."
                        class="w-full rounded-xl border border-gray-200 bg-transparent pl-11 pr-4 py-2.5 text-sm font-medium outline-none focus:border-brand-primary dark:border-gray-700 dark:text-white" />
                </div>

                <!-- Filter Status Pembayaran -->
                <div class="w-full sm:w-48">
                    <select name="status_pembayaran" onchange="this.form.submit()"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm font-medium outline-none focus:border-brand-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="">Semua Pembayaran</option>
                        <option value="belum_bayar" {{ request('status_pembayaran') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="lunas" {{ request('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="w-full sm:w-48">
                    <select name="sort" onchange="this.form.submit()"
                        class="w-full rounded-xl border border-gray-200 bg-transparent px-4 py-2.5 text-sm font-medium outline-none focus:border-brand-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="terbesar" {{ request('sort') == 'terbesar' ? 'selected' : '' }}>Denda Terbesar</option>
                        <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z (Peminjam)</option>
                    </select>
                </div>
            </form>

            <!-- Table Section with Responsive Scroll -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-800/50">
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500">Peminjam</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500">Buku & Kode</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">Pinjam / Deadline</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">Jumlah Denda</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">Status Pembayaran</th>
                            <th class="p-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                        @forelse($denda as $item)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/40 transition">
                                <!-- Peminjam -->
                                <td class="p-4">
                                    <div class="font-bold text-black dark:text-white">
                                        {{ $item->peminjaman->pengguna->anggota->nama_lengkap ?? $item->peminjaman->pengguna->nama_pengguna ?? 'Unknown' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $item->peminjaman->pengguna->email ?? '-' }}
                                    </div>
                                </td>

                                <!-- Buku & Kode -->
                                <td class="p-4">
                                    <div class="font-semibold text-black dark:text-white line-clamp-1 max-w-xs">
                                        {{ $item->peminjaman->buku->judul_buku ?? ($item->peminjaman->detail->first()->buku->judul_buku ?? 'Buku Perpustakaan') }}
                                    </div>
                                    <span class="inline-block mt-0.5 font-mono text-[11px] text-gray-500 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded">
                                        {{ $item->peminjaman->kode_booking }}
                                    </span>
                                </td>

                                <!-- Pinjam / Deadline -->
                                <td class="p-4 text-center">
                                    <div class="text-xs text-gray-600 dark:text-gray-300">
                                        Pinjam: {{ $item->peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($item->peminjaman->tgl_pinjam)->format('d M Y') : '-' }}
                                    </div>
                                    <div class="text-xs font-semibold text-red-600 dark:text-red-400">
                                        Deadline: {{ $item->peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->peminjaman->tgl_jatuh_tempo)->format('d M Y') : ($item->peminjaman->tgl_kembali ? \Carbon\Carbon::parse($item->peminjaman->tgl_kembali)->format('d M Y') : '-') }}
                                    </div>
                                </td>

                                <!-- Jumlah Denda -->
                                <td class="p-4 text-right">
                                    <span class="font-bold text-base text-red-600 dark:text-red-400 font-mono">
                                        Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}
                                    </span>
                                </td>

                                <!-- Status Pembayaran -->
                                <td class="p-4 text-center">
                                    @if($item->status_pembayaran === 'lunas')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                                            Lunas
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                            <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($item->status_pembayaran === 'belum_bayar')
                                            <form action="{{ route('admin.denda.bayar', $item->id_denda) }}" method="POST"
                                                  onsubmit="return confirm('Konfirmasi pelunasan denda sebesar Rp {{ number_format($item->jumlah_denda, 0, ',', '.') }}?')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 rounded-lg bg-green-600 px-3 py-1.5 text-xs font-bold text-white hover:bg-green-700 transition shadow-sm">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Bayar
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.denda.show', $item->id_denda) }}"
                                           class="inline-flex items-center gap-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-500">
                                    <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-black dark:text-white">Tidak ada data denda</p>
                                    <p class="text-xs text-gray-400 mt-1">Belum ada transaksi keterlambatan atau data pencarian tidak ditemukan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800">
                 {{ $denda->links() }}
            </div>
        </div>
    </div>
@endsection
