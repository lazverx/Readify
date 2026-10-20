@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Detail Denda Peminjaman
                </h2>
                <p class="text-sm text-gray-500 mt-1">Detail rincian tagihan keterlambatan dan status pembayaran</p>
            </div>
            <div class="flex items-center gap-3">
                @if($denda->status_pembayaran === 'belum_bayar')
                    <form action="{{ route('admin.denda.bayar', $denda->id_denda) }}" method="POST"
                          onsubmit="return confirm('Konfirmasi pelunasan denda sebesar Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-center font-bold text-white hover:bg-green-700 transition shadow-sm">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tandai Sudah Lunas
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.denda.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-center font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition">
                    ← Kembali
                </a>
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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Denda Specific Info (Card Kiri) -->
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-100 pb-4 dark:border-gray-800">
                    <h3 class="font-bold text-black dark:text-white text-lg">
                        Status Pembayaran
                    </h3>
                </div>
                <div class="pt-5 space-y-5">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Nominal Tagihan Denda</span>
                        <div class="mt-1 text-3xl font-extrabold text-red-600 dark:text-red-400 font-mono">
                            Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Dihitung Rp 2.000 / hari keterlambatan</p>
                    </div>

                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Status Saat Ini</span>
                        <div class="mt-2">
                            @if($denda->status_pembayaran === 'lunas')
                                <span class="inline-flex items-center gap-2 rounded-xl bg-green-100 px-4 py-2 text-sm font-bold text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                    <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>
                                    LUNAS / SELESAI
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 rounded-xl bg-red-100 px-4 py-2 text-sm font-bold text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                    <span class="h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse"></span>
                                    BELUM DIBAYAR
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500">
                        Dicatat pada: {{ $denda->dibuat_pada ? \Carbon\Carbon::parse($denda->dibuat_pada)->format('d F Y H:i') : '-' }}
                    </div>
                </div>
            </div>

            <!-- Transaction Info (Card Tengah) -->
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-100 pb-4 dark:border-gray-800">
                    <h3 class="font-bold text-black dark:text-white text-lg">
                        Data Peminjaman
                    </h3>
                </div>
                <div class="pt-5 space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Kode Booking</span>
                        <div class="mt-1 font-mono font-bold text-base text-brand-primary">
                            {{ $denda->peminjaman->kode_booking }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-500">Judul Buku</span>
                        <div class="mt-1 font-semibold text-black dark:text-white">
                            {{ $denda->peminjaman->buku->judul_buku ?? ($denda->peminjaman->detail->first()->buku->judul_buku ?? '-') }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div>
                            <span class="text-xs font-semibold text-gray-500">Tanggal Pinjam</span>
                            <div class="mt-1 text-sm text-black dark:text-white">
                                {{ $denda->peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($denda->peminjaman->tgl_pinjam)->format('d M Y') : '-' }}
                            </div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-500">Jatuh Tempo (Deadline)</span>
                            <div class="mt-1 text-sm font-semibold text-red-600">
                                {{ $denda->peminjaman->tgl_jatuh_tempo ? \Carbon\Carbon::parse($denda->peminjaman->tgl_jatuh_tempo)->format('d M Y') : ($denda->peminjaman->tgl_kembali ? \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d M Y') : '-') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrower Info (Card Kanan) -->
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-100 pb-4 dark:border-gray-800">
                    <h3 class="font-bold text-black dark:text-white text-lg">
                        Identitas Peminjam
                    </h3>
                </div>
                <div class="pt-5 space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">Nama Lengkap</span>
                        <div class="mt-1 font-bold text-black dark:text-white text-base">
                            {{ $denda->peminjaman->pengguna->anggota->nama_lengkap ?? $denda->peminjaman->pengguna->nama_pengguna ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-500">Username &amp; Email</span>
                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                            {{ $denda->peminjaman->pengguna->nama_pengguna }} ({{ $denda->peminjaman->pengguna->email }})
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-500">Nomor Telepon</span>
                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                            {{ $denda->peminjaman->pengguna->anggota->nomor_telepon ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-gray-500">Alamat</span>
                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                            {{ $denda->peminjaman->pengguna->anggota->alamat ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection