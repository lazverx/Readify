@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Page Header --}}
    <div>
        <h2 class="text-xl sm:text-2xl font-bold text-black">{{ __('messages.history_fines_title') }}</h2>
        <p class="text-sm text-gray-500 mt-1">{{ __('messages.history_fines_subtitle') }}</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm font-medium text-green-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm font-medium text-red-700">
            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ====== KIRI: Tabel Riwayat Peminjaman (2/3) ====== --}}
        <div class="xl:col-span-2">
            <div class="rounded-[20px] border border-gray-100 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
                    <div>
                        <h3 class="font-bold text-black text-base">{{ __('messages.history_tab') }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">{{ __('messages.history_sub') }}</p>
                    </div>
                    <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-2.5 sm:px-3 py-1 rounded-full">
                        {{ $history->count() }} {{ __('messages.books_unit') }}
                    </span>
                </div>

                <div class="p-3 sm:p-6">
                    @if($history->count() > 0)
                        {{-- Mobile Card View (< 640px) --}}
                        <div class="space-y-3 sm:hidden">
                            @foreach($history as $loan)
                                <div class="rounded-2xl border border-gray-100 bg-white p-3.5 shadow-xs">
                                    <div class="flex items-start gap-3">
                                        {{-- Sampul buku --}}
                                        <div class="h-18 w-13 shrink-0 rounded-lg overflow-hidden bg-gray-100 shadow-2xs">
                                            @if($loan->buku?->sampul)
                                                <img src="{{ Storage::url($loan->buku->sampul) }}" alt="{{ $loan->buku->judul_buku }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-[#e8f4f0]">
                                                    <svg class="h-6 w-6 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Info Buku --}}
                                        <div class="min-w-0 flex-1">
                                            <h4 class="font-bold text-black text-sm line-clamp-2 leading-snug">
                                                {{ $loan->buku?->judul_buku ?? __('messages.no_books_found') }}
                                            </h4>
                                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $loan->buku?->penulis ?? '-' }}</p>

                                            {{-- Badges: Status + Fine --}}
                                            <div class="flex flex-wrap items-center gap-1.5 mt-2">
                                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-[11px] font-semibold text-green-700">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                    {{ __('messages.badge_returned') }}
                                                </span>
                                                @if($loan->denda)
                                                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold
                                                        {{ $loan->denda->status_pembayaran === 'lunas' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-600' }}">
                                                        <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Rp {{ number_format($loan->denda->jumlah_denda, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tanggal & Tombol Cetak Struk --}}
                                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="h-3.5 w-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-medium">
                                                {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M') : '-' }}
                                                &rarr;
                                                {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->format('d M Y') : '-' }}
                                            </span>
                                        </div>

                                        <a href="{{ route('peminjaman.struk', $loan->id_peminjaman) }}" target="_blank"
                                            class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 hover:bg-gray-100 min-h-[38px] px-3 py-1.5 text-xs font-semibold text-gray-700 transition shadow-2xs shrink-0"
                                            title="{{ __('messages.print_receipt') }}">
                                            <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            <span>{{ __('messages.print_receipt') }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Desktop Table View (>= 640px) --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">{{ __('messages.books_unit') }}</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">{{ __('messages.borrow_date') }}</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">{{ __('messages.due_date') }}</th>
                                        <th class="text-left py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">Status</th>
                                        <th class="text-right py-3 px-3 font-semibold text-gray-500 text-xs uppercase tracking-wide">{{ __('messages.print_receipt') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($history as $loan)
                                        <tr class="hover:bg-gray-50/60 transition-colors group">
                                            <td class="py-4 px-3">
                                                <div class="flex items-center gap-3">
                                                    {{-- Sampul mini --}}
                                                    <div class="h-12 w-9 shrink-0 rounded-md overflow-hidden bg-gray-100 shadow-2xs">
                                                        @if($loan->buku?->sampul)
                                                            <img src="{{ Storage::url($loan->buku->sampul) }}" alt="{{ $loan->buku->judul_buku }}" class="h-full w-full object-cover">
                                                        @else
                                                            <div class="h-full w-full flex items-center justify-center bg-[#e8f4f0]">
                                                                <svg class="h-4 w-4 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="font-semibold text-black text-sm line-clamp-1 leading-snug">
                                                            {{ $loan->buku?->judul_buku ?? __('messages.no_books_found') }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $loan->buku?->penulis ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-3">
                                                <span class="text-sm text-gray-600">
                                                    {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-3">
                                                <span class="text-sm text-gray-600">
                                                    {{ $loan->tgl_kembali ? \Carbon\Carbon::parse($loan->tgl_kembali)->format('d M Y') : '-' }}
                                                </span>
                                            </td>
                                            <td class="py-4 px-3">
                                                <div class="flex flex-col gap-1">
                                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700 self-start">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                                        {{ __('messages.badge_returned') }}
                                                    </span>
                                                    @if($loan->denda)
                                                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold self-start
                                                            {{ $loan->denda->status_pembayaran === 'lunas' ? 'bg-gray-100 text-gray-500' : 'bg-red-100 text-red-600' }}">
                                                            <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Rp {{ number_format($loan->denda->jumlah_denda, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-4 px-3 text-right">
                                                <a href="{{ route('peminjaman.struk', $loan->id_peminjaman) }}" target="_blank"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-50 transition shadow-2xs"
                                                    title="{{ __('messages.print_receipt') }}">
                                                    <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                    <span>{{ __('messages.print_receipt') }}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 text-center">
                            <div class="rounded-full bg-gray-50 p-5 mb-4">
                                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p class="font-bold text-black">{{ __('messages.no_history') }}</p>
                            <p class="text-sm text-gray-400 mt-1">{{ __('messages.no_history_desc') }}</p>
                            <a href="{{ route('anggota.dashboard') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-[#0f4c3a] hover:underline">
                                {{ __('messages.browse_catalog') }} →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ====== KANAN: Widget Tagihan Denda (1/3) ====== --}}
        <div class="flex flex-col gap-6">

            {{-- Total Denda Summary Card --}}
            @php $totalDenda = $tagihanDenda->sum('jumlah_denda'); @endphp
            <div class="rounded-[20px] border bg-white shadow-sm overflow-hidden {{ $totalDenda > 0 ? 'border-red-200' : 'border-gray-100' }}">
                <div class="px-4 sm:px-6 py-4 sm:py-5 border-b {{ $totalDenda > 0 ? 'border-red-100 bg-red-50' : 'border-gray-100' }}">
                    <h3 class="font-bold text-black text-base">{{ __('messages.fines_tab') }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ __('messages.fines_sub') }}</p>
                </div>

                <div class="p-4 sm:p-6">
                    @if($tagihanDenda->count() > 0)
                        <div class="flex flex-col gap-3 mb-5">
                            @foreach($tagihanDenda as $denda)
                                <div class="flex items-start gap-3 rounded-xl border border-red-100 bg-red-50 p-3">
                                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100">
                                        <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-black line-clamp-1">
                                            {{ $denda->peminjaman?->buku?->judul_buku ?? __('messages.no_books_found') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ __('messages.due_date') }}: {{ $denda->peminjaman?->tgl_kembali ? \Carbon\Carbon::parse($denda->peminjaman->tgl_kembali)->format('d M Y') : '-' }}
                                        </p>
                                        <p class="text-sm font-bold text-red-600 mt-1">
                                            Rp {{ number_format($denda->jumlah_denda, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Total --}}
                        <div class="flex items-center justify-between rounded-xl bg-gray-50 px-4 py-3 border border-gray-100">
                            <span class="text-sm font-medium text-gray-600">{{ __('messages.total_fines_bill') }}</span>
                            <span class="text-lg font-bold text-red-600">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                        </div>

                        {{-- Info bayar --}}
                        <div class="mt-4 flex items-start gap-2 rounded-xl border border-amber-100 bg-amber-50 p-3">
                            <svg class="h-4 w-4 mt-0.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-amber-700 leading-relaxed">
                                {{ __('messages.pay_fines_instruction') }}
                            </p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8 text-center">
                            <div class="rounded-full bg-green-50 p-4 mb-3">
                                <svg class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-black text-sm">{{ __('messages.no_fines') }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ __('messages.no_fines_desc') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="rounded-[20px] border border-gray-100 bg-white shadow-sm p-4 sm:p-6">
                <h4 class="font-bold text-black text-sm mb-4">{{ __('messages.reading_statistics') }}</h4>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('messages.total_borrowed') }}</span>
                        <span class="font-bold text-black">{{ $history->count() }} {{ __('messages.books_unit') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('messages.fined_history') }}</span>
                        <span class="font-bold {{ $history->filter(fn($l) => $l->denda)->count() > 0 ? 'text-red-500' : 'text-black' }}">
                            {{ $history->filter(fn($l) => $l->denda)->count() }} {{ __('messages.times') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ __('messages.total_fines_paid') }}</span>
                        <span class="font-bold text-gray-500">
                            Rp {{ number_format($history->filter(fn($l) => $l->denda && $l->denda->status_pembayaran === 'lunas')->sum(fn($l) => $l->denda->jumlah_denda), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection