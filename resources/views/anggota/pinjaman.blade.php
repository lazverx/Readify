
@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">

        {{-- ===== ALERTS ===== --}}
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 shadow-sm">
                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-green-500">
                    <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-green-800">{!! session('success') !!}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-500">
                    <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-red-800">{!! session('error') !!}</p>
            </div>
        @endif

        {{-- Header --}}
        {{-- Header --}}
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-black">{{ __('messages.my_loans_title') }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ __('messages.my_loans_subtitle') }}</p>
        </div>

        {{-- Pinjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 px-4 sm:px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold text-black text-base sm:text-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
                    </svg>
                    {{ __('messages.active_loans_list') }}
                </h3>
                <span class="text-xs sm:text-sm text-gray-500 font-medium">{{ $pinjaman->count() }} {{ __('messages.books_unit') }}</span>
            </div>

            @if($pinjaman->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($pinjaman as $item)
                        @php
                            $jatuhTempo = $item->tgl_jatuh_tempo ?? $item->tgl_kembali;
                            $sisaHari = $jatuhTempo ? (int) \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($jatuhTempo->toDateString()), false) : null;
                            $status = $item->status_transaksi;
                        @endphp
                        <div class="p-4 sm:p-6 flex flex-col md:flex-row items-stretch md:items-center gap-4">

                            {{-- Info Utama: Cover + Detail --}}
                            <div class="flex items-start gap-3 sm:gap-4 flex-1 min-w-0">
                                {{-- Cover Buku --}}
                                <div class="shrink-0">
                                    @if($item->buku?->sampul)
                                        <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}"
                                            class="h-20 w-14 rounded-lg object-cover shadow-xs">
                                    @else
                                        <div class="h-20 w-14 rounded-lg bg-gradient-to-br from-[#e8f4f0] to-[#c8e6d8] flex items-center justify-center">
                                            <svg class="h-7 w-7 text-[#0f4c3a] opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info Buku --}}
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-black text-sm sm:text-base line-clamp-1">{{ $item->buku?->judul_buku ?? __('messages.no_books_found') }}</h4>
                                    <p class="text-xs sm:text-sm text-gray-500 mb-2">{{ $item->buku?->penulis ?? '-' }}</p>

                                    {{-- Banner Kode Booking menonjol (hanya saat status booking) --}}
                                    @if($status === 'booking')
                                        <div class="mb-3 rounded-xl border-2 border-[#004236] bg-[#004236]/5 p-3">
                                            <p class="text-[10px] font-bold uppercase tracking-widest text-[#004236] mb-1.5 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                                </svg>
                                                {{ __('messages.show_booking_code') }}
                                            </p>
                                            <div class="flex items-center justify-between gap-3">
                                                <span class="font-mono text-xl sm:text-2xl font-black tracking-widest text-[#004236]">{{ $item->kode_booking }}</span>
                                                <button
                                                    onclick="navigator.clipboard.writeText('{{ $item->kode_booking }}').then(() => { this.textContent = '{{ __('messages.action_copied') }}'; setTimeout(() => this.textContent = '{{ __('messages.action_copy') }}', 2000); })"
                                                    class="shrink-0 rounded-lg border border-[#004236] bg-white px-2.5 py-1.5 text-[11px] font-bold text-[#004236] hover:bg-[#004236] hover:text-white transition">
                                                    {{ __('messages.action_copy') }}
                                                </button>
                                            </div>
                                            <p class="mt-2 text-[10px] text-[#004236]/70">
                                                {{ __('messages.booking_code_desc') }} <strong>{{ $item->tgl_jatuh_tempo ? \Carbon\Carbon::parse($item->tgl_jatuh_tempo)->format('d M Y') : '-' }}</strong>.
                                            </p>
                                        </div>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs text-gray-500">
                                        {{-- Kode Booking (mini, untuk status selain booking) --}}
                                        @if($status !== 'booking')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 font-mono font-bold text-gray-700 text-[11px]">
                                            <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                            {{ $item->kode_booking }}
                                        </span>
                                        @endif

                                        {{-- Tgl Pinjam --}}
                                        @if($item->tgl_pinjam)
                                        <span class="flex items-center gap-1">
                                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ __('messages.borrow_date') }}: {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d M Y') }}
                                        </span>
                                        @endif

                                        {{-- Jatuh Tempo --}}
                                        @if($jatuhTempo)
                                        <span class="flex items-center gap-1 {{ $status == 'terlambat' ? 'text-red-600 font-semibold' : '' }}">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('messages.due_date') }}: {{ \Carbon\Carbon::parse($jatuhTempo->toDateString())->format('d M Y') }}
                                        </span>
                                        @endif

                                        {{-- Durasi --}}
                                        @if($item->durasi_pinjam)
                                        <span class="text-gray-400">{{ $item->durasi_pinjam }} {{ __('messages.days') }}</span>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            {{-- Status & Aksi --}}
                            <div class="flex md:flex-col items-center md:items-end justify-between md:justify-start gap-2.5 pt-3 md:pt-0 border-t border-gray-100 md:border-0 shrink-0">
                                {{-- Badge Status --}}
                                <div class="flex items-center gap-2">
                                    @if($status == 'terlambat')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                            <span class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></span>
                                            {{ __('messages.badge_overdue_caps') }}
                                            @if($sisaHari !== null)
                                                ({{ abs($sisaHari) }} {{ __('messages.days') }})
                                            @endif
                                        </span>
                                        @if($sisaHari !== null)
                                            <span class="text-[11px] font-bold text-red-600 bg-red-50 border border-red-200 px-2 py-0.5 rounded-full">
                                                Rp {{ number_format(abs($sisaHari) * 2000, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    @elseif($status == 'dipinjam')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1.5 text-xs font-bold text-yellow-700">
                                            <span class="h-2 w-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                            {{ __('messages.badge_active_caps') }}
                                            @if($sisaHari !== null)
                                                ({{ $sisaHari }} {{ __('messages.days_left') }})
                                            @endif
                                        </span>
                                    @elseif($status == 'booking')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700">
                                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                            {{ __('messages.badge_booking_caps') }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-2">
                                    {{-- Tombol Perpanjang (hanya untuk dipinjam atau terlambat) --}}
                                    @if(in_array($status, ['dipinjam', 'terlambat']))
                                        <div x-data="{ showPerpanjang: false }">
                                            <button @click="showPerpanjang = true"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-[#0f4c3a] px-3 py-1.5 text-xs font-bold text-[#0f4c3a] hover:bg-[#0f4c3a] hover:text-white transition-colors">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                {{ __('messages.extend_loan') }}
                                            </button>

                                            {{-- Modal Perpanjang --}}
                                            <div x-show="showPerpanjang" x-transition
                                                class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                                                style="display: none;">
                                                <div @click.outside="showPerpanjang = false"
                                                    class="w-full max-w-sm rounded-2xl bg-white p-6 sm:p-8 shadow-2xl">
                                                    <h3 class="mb-2 text-xl font-bold text-black">{{ __('messages.extend_modal_title') }}</h3>
                                                    <p class="mb-1 text-sm text-gray-500 line-clamp-2">{{ $item->buku?->judul_buku }}</p>
                                                    <p class="mb-5 text-xs text-gray-400">
                                                        {{ __('messages.extend_rule_note') }}
                                                    </p>

                                                    <form action="{{ route('anggota.pinjaman.perpanjang', $item->id_peminjaman) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-5">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.extend_add_duration') }}</label>
                                                            <div class="grid grid-cols-2 gap-3">
                                                                <label class="flex items-center gap-2 cursor-pointer rounded-xl border-2 border-gray-200 p-3 has-[:checked]:border-[#0f4c3a] has-[:checked]:bg-[#e8f4f0] transition-all">
                                                                    <input type="radio" name="tambah_hari" value="2" class="text-[#0f4c3a]" required>
                                                                    <div>
                                                                        <div class="font-bold text-black">+2 {{ __('messages.days') }}</div>
                                                                        <div class="text-xs text-gray-500">{{ __('messages.extend_2_days') }}</div>
                                                                    </div>
                                                                </label>
                                                                <label class="flex items-center gap-2 cursor-pointer rounded-xl border-2 border-gray-200 p-3 has-[:checked]:border-[#0f4c3a] has-[:checked]:bg-[#e8f4f0] transition-all">
                                                                    <input type="radio" name="tambah_hari" value="3" class="text-[#0f4c3a]">
                                                                    <div>
                                                                        <div class="font-bold text-black">+3 {{ __('messages.days') }}</div>
                                                                        <div class="text-xs text-gray-500">{{ __('messages.extend_3_days') }}</div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="flex gap-3">
                                                            <button type="button" @click="showPerpanjang = false"
                                                                class="flex-1 rounded-xl border border-gray-300 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                                                {{ __('messages.action_cancel') }}
                                                            </button>
                                                            <button type="submit"
                                                                class="flex-1 rounded-xl bg-[#0f4c3a] py-2.5 text-sm font-bold text-white hover:bg-[#0a382b] transition">
                                                                {{ __('messages.extend_loan') }}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Tombol Cetak Struk Bukti --}}
                                    <a href="{{ route('peminjaman.struk', $item->id_peminjaman) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-2xs"
                                        title="{{ __('messages.print_receipt') }}">
                                        <svg class="h-3.5 w-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                        </svg>
                                        {{ __('messages.print_receipt') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center px-4">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-black mb-1">{{ __('messages.no_active_loans') }}</h4>
                    <p class="text-sm text-gray-500 mb-4">{{ __('messages.no_active_loans_desc') }}</p>
                    <a href="{{ route('anggota.dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#0f4c3a] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#0a382b] transition">
                        {{ __('messages.browse_catalog') }}
                    </a>
                </div>
            @endif
        </div>

        {{-- Keterangan Status --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm p-4 sm:p-5">
            <h3 class="font-bold text-black mb-3 text-sm">{{ __('messages.status_legend_title') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 border border-blue-100 p-2.5 font-medium text-blue-700">
                    <span class="h-2 w-2 shrink-0 rounded-full bg-blue-500"></span>
                    {{ __('messages.status_booking_desc') }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-yellow-50 border border-yellow-100 p-2.5 font-medium text-yellow-700">
                    <span class="h-2 w-2 shrink-0 rounded-full bg-yellow-500"></span>
                    {{ __('messages.status_active_desc') }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-green-50 border border-green-100 p-2.5 font-medium text-green-700">
                    <span class="h-2 w-2 shrink-0 rounded-full bg-green-500"></span>
                    {{ __('messages.status_returned_desc') }}
                </span>
                <span class="inline-flex items-center gap-1.5 rounded-xl bg-red-50 border border-red-100 p-2.5 font-medium text-red-700">
                    <span class="h-2 w-2 shrink-0 rounded-full bg-red-500"></span>
                    {{ __('messages.status_overdue_desc') }}
                </span>
            </div>
        </div>

        {{-- Riwayat Terakhir Dikembalikan --}}
        @if($riwayat->count() > 0)
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-gray-100 px-4 sm:px-6 py-4">
                <h3 class="font-bold text-black text-base sm:text-lg flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('messages.recently_returned_title') }}
                </h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($riwayat as $item)
                <div class="px-4 sm:px-6 py-4 flex items-center gap-3 sm:gap-4">
                    <div class="shrink-0">
                        @if($item->buku?->sampul)
                            <img src="{{ Storage::url($item->buku->sampul) }}" alt="{{ $item->buku->judul_buku }}"
                                class="h-12 w-9 rounded object-cover shadow-2xs">
                        @else
                            <div class="h-12 w-9 rounded bg-gray-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-black line-clamp-1">{{ $item->buku?->judul_buku ?? '-' }}</h4>
                        <p class="text-xs text-gray-400">
                            {{ __('messages.returned_at') }}: {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-bold text-green-700 shrink-0">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        {{ __('messages.badge_returned') }}
                    </span>
                </div>
                @endforeach
            </div>
            <div class="px-4 sm:px-6 py-3 border-t border-gray-100">
                <a href="{{ route('anggota.riwayat') }}" class="text-sm text-[#0f4c3a] font-medium hover:underline inline-flex items-center gap-1">
                    {{ __('messages.view_all_history') }} →
                </a>
            </div>
        </div>
        @endif

    </div>
@endsection
