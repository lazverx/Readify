@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10" x-data="katalogManager()">

        {{-- ========================================================= --}}
        {{-- FEATURE 3: ALERT PENGINGAT JATUH TEMPO (H-2 / H-1 / OVERDUE) --}}
        {{-- ========================================================= --}}
        @if(isset($bukuJatuhTempo) && $bukuJatuhTempo->isNotEmpty())
            <div class="mb-6 space-y-3">
                @foreach($bukuJatuhTempo as $itemTempo)
                    @php
                        $isOverdue = $itemTempo->sisa_hari < 0;
                        $isToday = $itemTempo->sisa_hari === 0;
                        $tglFormat = \Carbon\Carbon::parse($itemTempo->tgl_jatuh_tempo)->format('d M Y');
                    @endphp
                    <div class="relative overflow-hidden rounded-2xl border {{ $isOverdue ? 'border-red-200 bg-red-50/80 text-red-900' : 'border-amber-200 bg-amber-50/80 text-amber-900' }} p-4 sm:p-5 shadow-sm">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-3.5">
                                <div class="shrink-0 rounded-xl p-2.5 {{ $isOverdue ? 'bg-red-500 text-white' : 'bg-amber-500 text-white' }}">
                                    @if($isOverdue)
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider {{ $isOverdue ? 'bg-red-200 text-red-800' : 'bg-amber-200 text-amber-800' }}">
                                            {{ $isOverdue ? 'Terlambat ' . abs($itemTempo->sisa_hari) . ' Hari' : ($isToday ? 'Jatuh Tempo Hari Ini!' : 'Jatuh Tempo H-' . $itemTempo->sisa_hari) }}
                                        </span>
                                        <span class="text-xs font-semibold opacity-75">Batas: {{ $tglFormat }}</span>
                                    </div>
                                    <h4 class="text-sm sm:text-base font-bold mt-1">
                                        Buku: "{{ $itemTempo->buku->judul_buku ?? 'Buku Perpustakaan' }}"
                                    </h4>
                                    <p class="text-xs mt-0.5 opacity-90">
                                        {{ $isOverdue ? 'Denda berjalan Rp 1.000/hari. Harap segera kembalikan buku ke perpustakaan untuk menghindari akumulasi denda.' : 'Segera lakukan perpanjangan peminjaman atau kembalikan buku sebelum tanggal jatuh tempo agar terbebas dari denda.' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                <a href="{{ route('anggota.pinjaman') }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-xs font-bold shadow-sm transition-all {{ $isOverdue ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-amber-600 hover:bg-amber-700 text-white' }}">
                                    <span>Kelola Pinjaman</span>
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ========================================================= --}}
        {{-- FEATURE 4: HEADER & GAMIFIKASI HIGHLIGHT BANNER --}}
        {{-- ========================================================= --}}
        <div class="mb-6 grid grid-cols-1 gap-4 lg:grid-cols-3">
            {{-- Welcome & Stats Card --}}
            <div class="rounded-2xl border border-gray-100 bg-linear-to-br from-[#0f4c3a] to-[#1a6650] p-6 text-white shadow-sm lg:col-span-2 relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/5 rounded-full blur-xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-medium backdrop-blur-sm mb-3">
                            <span>Selamat Datang di Readify</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Katalog Terpadu</span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                            Jelajahi Koleksi Literasi Digital
                        </h2>
                        <p class="mt-1 text-sm text-emerald-100/90 max-w-xl">
                            Temukan ribuan buku pilihan, manga, novel, sains, dan teknologi. Pinjam dengan mudah dan raih lencana literasi!
                        </p>
                    </div>

                    {{-- Member Quick Stats --}}
                    <div class="mt-6 pt-4 border-t border-white/10 grid grid-cols-3 gap-3">
                        <div class="bg-white/10 rounded-xl p-2.5 backdrop-blur-sm">
                            <span class="text-[11px] text-emerald-200 block">Total Dipinjam</span>
                            <span class="text-lg font-bold">{{ $userStats['total_pinjam'] ?? 0 }} Buku</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-2.5 backdrop-blur-sm">
                            <span class="text-[11px] text-emerald-200 block">Peringkat Kamu</span>
                            <span class="text-lg font-bold">#{{ $userStats['rank'] ?? '-' }}</span>
                        </div>
                        <div class="bg-white/10 rounded-xl p-2.5 backdrop-blur-sm">
                            <span class="text-[11px] text-emerald-200 block">Lencana Pembaca</span>
                            <a href="{{ route('anggota.profile') }}" class="text-xs font-bold text-amber-300 hover:text-white inline-flex items-center gap-1 mt-1">
                                Lihat Lencana
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leaderboard Preview Card --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Top Pembaca Bulan Ini</h3>
                                <p class="text-[11px] text-gray-500">Anggota paling aktif meminjam buku</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700">Leaderboard</span>
                    </div>

                    <div class="space-y-2 mt-2">
                        @forelse(array_slice($leaderboard, 0, 3) as $userTop)
                            <div class="flex items-center justify-between p-2 rounded-xl {{ $userTop['rank'] === 1 ? 'bg-amber-50/70 border border-amber-100' : 'bg-gray-50' }}">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-extrabold text-xs {{ $userTop['rank'] === 1 ? 'bg-amber-100 text-amber-800' : ($userTop['rank'] === 2 ? 'bg-gray-200 text-gray-700' : 'bg-amber-50 text-amber-900') }}">
                                        #{{ $userTop['rank'] }}
                                    </span>
                                    <div class="w-7 h-7 rounded-full bg-[#0f4c3a] text-white flex items-center justify-center text-xs font-bold shrink-0 overflow-hidden">
                                        @if($userTop['foto'])
                                            <img src="{{ $userTop['foto'] }}" class="w-full h-full object-cover">
                                        @else
                                            {{ $userTop['initials'] }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $userTop['nama'] }}</p>
                                        <p class="text-[10px] text-gray-500">{{ $userTop['badge_title'] }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-[#0f4c3a] shrink-0 bg-white px-2 py-0.5 rounded-lg border border-gray-100">
                                    {{ $userTop['total_pinjam'] }} buku
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 text-center py-4">Belum ada data peminjaman</p>
                        @endforelse
                    </div>
                </div>

                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-[11px] text-gray-500">Tingkatkan terus pinjamanmu!</span>
                    <a href="{{ route('anggota.profile') }}" class="text-xs font-bold text-[#0f4c3a] hover:underline">
                        Profil & Lencana
                    </a>
                </div>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- FEATURE 6: LIVE SEARCH, CATEGORY PILLS & AVAILABILITY FILTER --}}
        {{-- ========================================================= --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm mb-6">
            
            {{-- Top Controls: Search Bar, Availability Toggle, Sort --}}
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3 mb-4">
                {{-- Search Box --}}
                <div class="relative flex-1">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" id="katalog-search"
                        placeholder="Ketik judul buku, penulis, ISBN, atau sinopsis..."
                        value="{{ request('search') }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/50 pl-11 pr-10 py-2.5 text-sm font-medium outline-none transition-all focus:border-[#0f4c3a] focus:bg-white focus:ring-2 focus:ring-[#0f4c3a]/15"
                        autocomplete="off" />
                    
                    {{-- Spinner --}}
                    <span id="search-spinner" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                        <svg class="h-4 w-4 animate-spin text-[#0f4c3a]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </span>
                </div>

                {{-- Toggle: Hanya Buku Tersedia --}}
                <label class="flex items-center gap-2.5 px-3 py-2 rounded-xl border border-gray-200 bg-gray-50/50 hover:bg-gray-100/60 cursor-pointer select-none transition-colors shrink-0">
                    <input type="checkbox" id="filter-tersedia" class="w-4 h-4 rounded text-[#0f4c3a] focus:ring-[#0f4c3a] border-gray-300">
                    <span class="text-xs font-semibold text-gray-700">Hanya Tersedia</span>
                </label>

                {{-- Sort Dropdown --}}
                <div class="relative w-full md:w-44 shrink-0">
                    <select id="filter-sort"
                        class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50/50 px-3.5 py-2.5 pr-8 text-xs font-semibold text-gray-700 outline-none transition-all focus:border-[#0f4c3a] focus:bg-white">
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                        <option value="az">Judul (A - Z)</option>
                        <option value="za">Judul (Z - A)</option>
                    </select>
                    <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                {{-- Reset Button --}}
                <button type="button" onclick="window.resetKatalogFilter()"
                    class="rounded-xl border border-gray-200 px-3.5 py-2.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 transition-colors shrink-0 flex items-center justify-center gap-1.5">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset</span>
                </button>
            </div>

            {{-- Category Filter Pills --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 pt-1 no-scrollbar">
                <button type="button" data-kategori=""
                    class="kat-pill px-3 py-1.5 rounded-full text-xs font-bold transition-all shrink-0 bg-[#0f4c3a] text-white shadow-sm">
                    Semua
                </button>
                @foreach($kategori as $kat)
                    <button type="button" data-kategori="{{ $kat->nama_kategori }}"
                        class="kat-pill px-3 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 bg-gray-100 text-gray-700 hover:bg-gray-200">
                        {{ $kat->nama_kategori }}
                    </button>
                @endforeach
            </div>

            {{-- Result Count & Active Filters Indicator --}}
            <div class="mt-3 flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-100">
                <span id="katalog-count">Menampilkan koleksi buku perpustakaan</span>
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Live Search Aktif</span>
                </span>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- BUKU GRID CONTAINER --}}
        {{-- ========================================================= --}}
        <div id="buku-grid" class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            @include('anggota.partials.buku-grid', ['buku' => $buku])
        </div>

        {{-- Pagination --}}
        <div id="pagination-container" class="mt-8">
            {{ $buku->links() }}
        </div>

        {{-- ========================================================= --}}
        {{-- FEATURE 6: QUICK PREVIEW MODAL --}}
        {{-- ========================================================= --}}
        <div id="quick-preview-modal" class="fixed inset-0 z-99999 hidden overflow-y-auto" role="dialog" aria-modal="true">
            {{-- Backdrop --}}
            <div id="modal-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity duration-200"></div>

            {{-- Modal Content Box --}}
            <div class="flex min-h-screen items-center justify-center p-4">
                <div id="modal-box" class="relative w-full max-w-2xl transform rounded-2xl bg-white p-6 shadow-2xl transition-all duration-200 scale-95 opacity-0">
                    
                    {{-- Close Button --}}
                    <button type="button" onclick="window.closeQuickPreview()"
                        class="absolute top-4 right-4 w-9 h-9 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-black flex items-center justify-center transition-colors z-10"
                        title="Tutup (Esc)">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    {{-- Modal Body --}}
                    <div id="modal-loading" class="py-16 flex flex-col items-center justify-center">
                        <svg class="h-8 w-8 animate-spin text-[#0f4c3a]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        <p class="text-xs text-gray-500 mt-2 font-medium">Memuat pratinjau buku...</p>
                    </div>

                    <div id="modal-content" class="hidden">
                        <div class="flex flex-col sm:flex-row gap-6">
                            {{-- Cover Image --}}
                            <div class="w-full sm:w-48 shrink-0">
                                <div class="relative aspect-2/3 w-full overflow-hidden rounded-xl bg-gray-100 shadow-md">
                                    <img id="modal-sampul" src="" alt="Cover Buku" class="w-full h-full object-cover">
                                    <div id="modal-sampul-fallback" class="hidden w-full h-full bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8] flex items-center justify-center">
                                        <svg class="h-16 w-16 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                            </path>
                                        </svg>
                                    </div>
                                    <span id="modal-stok-badge" class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-bold text-white shadow"></span>
                                </div>
                            </div>

                            {{-- Book Details --}}
                            <div class="flex-1 flex flex-col justify-between min-w-0">
                                <div>
                                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                        <span id="modal-kategori" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200"></span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gray-700">
                                            <svg class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span id="modal-rak"></span>
                                        </span>
                                    </div>

                                    <h3 id="modal-judul" class="text-lg sm:text-xl font-extrabold text-gray-900 leading-snug"></h3>
                                    <p id="modal-penulis" class="text-xs font-semibold text-gray-600 mt-1"></p>

                                    {{-- Info Grid --}}
                                    <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-gray-600 py-2 border-y border-gray-100">
                                        <div><span class="font-medium text-gray-500">Penerbit:</span> <span id="modal-penerbit" class="font-bold text-gray-800"></span></div>
                                        <div><span class="font-medium text-gray-500">Tahun:</span> <span id="modal-tahun" class="font-bold text-gray-800"></span></div>
                                        <div class="col-span-2"><span class="font-medium text-gray-500">ISBN:</span> <span id="modal-isbn" class="font-mono text-gray-800"></span></div>
                                    </div>

                                    {{-- Synopsis --}}
                                    <div class="mt-3">
                                        <h4 class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Sinopsis Ringkas</h4>
                                        <div id="modal-sinopsis" class="text-xs text-gray-700 leading-relaxed max-h-32 overflow-y-auto pr-1"></div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                                    <a id="modal-detail-btn" href="#"
                                        class="rounded-xl border border-gray-200 px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 transition-colors">
                                        Lihat Halaman Penuh
                                    </a>

                                    <div id="modal-action-container">
                                        {{-- Dynamic Borrow Button or Status Badge --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        (function() {
            let searchTimeout = null;
            let currentSearch = @json(request('search', ''));
            let currentKategori = @json(request('kategori', ''));
            let currentSort = @json(request('sort', 'terbaru'));
            let currentHanyaTersedia = false;

            const searchInput = document.getElementById('katalog-search');
            const spinner = document.getElementById('search-spinner');
            const grid = document.getElementById('buku-grid');
            const paginationContainer = document.getElementById('pagination-container');
            const selectSort = document.getElementById('filter-sort');
            const toggleTersedia = document.getElementById('filter-tersedia');
            const katPills = document.querySelectorAll('.kat-pill');
            const countLabel = document.getElementById('katalog-count');

            // Quick Preview Modal Elements
            const modal = document.getElementById('quick-preview-modal');
            const modalBox = document.getElementById('modal-box');
            const modalBackdrop = document.getElementById('modal-backdrop');
            const modalLoading = document.getElementById('modal-loading');
            const modalContent = document.getElementById('modal-content');

            // Fetch buku via AJAX
            function fetchBuku(page) {
                page = page || 1;
                if (spinner) spinner.classList.remove('hidden');

                const params = new URLSearchParams();
                if (currentSearch) params.set('search', currentSearch);
                if (currentKategori) params.set('kategori', currentKategori);
                if (currentSort) params.set('sort', currentSort);
                if (currentHanyaTersedia) params.set('hanya_tersedia', '1');
                params.set('page', page);
                params.set('ajax', '1');

                // Update URL bar
                const displayParams = new URLSearchParams();
                if (currentSearch) displayParams.set('search', currentSearch);
                if (currentKategori) displayParams.set('kategori', currentKategori);
                if (currentSort && currentSort !== 'terbaru') displayParams.set('sort', currentSort);
                if (currentHanyaTersedia) displayParams.set('hanya_tersedia', '1');
                if (page > 1) displayParams.set('page', page);
                
                const newUrl = window.location.pathname + (displayParams.toString() ? '?' + displayParams.toString() : '');
                history.replaceState(null, '', newUrl);

                fetch(window.location.pathname + '?' + params.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(function(data) {
                    grid.innerHTML = data.html;
                    paginationContainer.innerHTML = data.pagination;
                    if (countLabel && typeof data.total !== 'undefined') {
                        countLabel.textContent = 'Ditemukan ' + data.total + ' buku sesuai kriteria pencarian';
                    }
                    bindPaginationLinks();
                    if (spinner) spinner.classList.add('hidden');
                })
                .catch(function() {
                    if (spinner) spinner.classList.add('hidden');
                });
            }

            // Bind pagination links
            function bindPaginationLinks() {
                paginationContainer.querySelectorAll('a[href]').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        try {
                            const url = new URL(this.href);
                            const page = url.searchParams.get('page') || 1;
                            fetchBuku(page);
                            window.scrollTo({ top: grid.offsetTop - 100, behavior: 'smooth' });
                        } catch(err) {
                            window.location.href = this.href;
                        }
                    });
                });
            }

            // Live search dengan debounce 350ms
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        currentSearch = searchInput.value.trim();
                        fetchBuku(1);
                    }, 350);
                });
            }

            // Toggle hanya buku tersedia
            if (toggleTersedia) {
                toggleTersedia.addEventListener('change', function() {
                    currentHanyaTersedia = this.checked;
                    fetchBuku(1);
                });
            }

            // Sort change
            if (selectSort) {
                selectSort.addEventListener('change', function() {
                    currentSort = this.value;
                    fetchBuku(1);
                });
            }

            // Category pills handler
            katPills.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const selectedKat = this.getAttribute('data-kategori');
                    currentKategori = selectedKat;

                    // Update UI active state
                    katPills.forEach(function(p) {
                        p.className = 'kat-pill px-3 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 bg-gray-100 text-gray-700 hover:bg-gray-200';
                    });
                    this.className = 'kat-pill px-3 py-1.5 rounded-full text-xs font-bold transition-all shrink-0 bg-[#0f4c3a] text-white shadow-sm';

                    fetchBuku(1);
                });
            });

            // Global Reset Filter
            window.resetKatalogFilter = function() {
                if (searchInput) searchInput.value = '';
                if (toggleTersedia) toggleTersedia.checked = false;
                if (selectSort) selectSort.value = 'terbaru';
                currentSearch = '';
                currentKategori = '';
                currentSort = 'terbaru';
                currentHanyaTersedia = false;

                katPills.forEach(function(p, idx) {
                    if (idx === 0) {
                        p.className = 'kat-pill px-3 py-1.5 rounded-full text-xs font-bold transition-all shrink-0 bg-[#0f4c3a] text-white shadow-sm';
                    } else {
                        p.className = 'kat-pill px-3 py-1.5 rounded-full text-xs font-semibold transition-all shrink-0 bg-gray-100 text-gray-700 hover:bg-gray-200';
                    }
                });

                fetchBuku(1);
            };

            // Quick Preview Modal Handler
            window.openQuickPreview = function(idBuku) {
                modal.classList.remove('hidden');
                modalLoading.classList.remove('hidden');
                modalContent.classList.add('hidden');

                // Animate entrance
                setTimeout(function() {
                    modalBox.classList.remove('scale-95', 'opacity-0');
                    modalBox.classList.add('scale-100', 'opacity-100');
                }, 10);

                fetch('/anggota/buku/' + idBuku + '/quick-preview', {
                    headers: { 'Accept': 'application/json' }
                })
                .then(function(res) {
                    if (!res.ok) throw new Error('Gagal memuat detail buku');
                    return res.json();
                })
                .then(function(data) {
                    // Populate fields
                    document.getElementById('modal-judul').textContent = data.judul_buku;
                    document.getElementById('modal-penulis').textContent = 'Oleh: ' + data.penulis;
                    document.getElementById('modal-penerbit').textContent = data.penerbit;
                    document.getElementById('modal-tahun').textContent = data.tahun_terbit;
                    document.getElementById('modal-isbn').textContent = data.isbn;
                    document.getElementById('modal-kategori').textContent = data.kategori_utama;
                    document.getElementById('modal-rak').textContent = data.rak;
                    document.getElementById('modal-sinopsis').textContent = data.sinopsis;
                    document.getElementById('modal-detail-btn').href = data.detail_url;

                    // Cover
                    const imgCover = document.getElementById('modal-sampul');
                    const fallbackCover = document.getElementById('modal-sampul-fallback');
                    if (data.sampul_url) {
                        imgCover.src = data.sampul_url;
                        imgCover.classList.remove('hidden');
                        fallbackCover.classList.add('hidden');
                    } else {
                        imgCover.classList.add('hidden');
                        fallbackCover.classList.remove('hidden');
                    }

                    // Stock badge
                    const stokBadge = document.getElementById('modal-stok-badge');
                    if (data.stok > 0) {
                        stokBadge.textContent = 'Tersedia (' + data.stok + ')';
                        stokBadge.className = 'absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-bold text-white shadow bg-emerald-600';
                    } else {
                        stokBadge.textContent = 'Stok Habis';
                        stokBadge.className = 'absolute top-2 left-2 px-2 py-0.5 rounded-full text-[10px] font-bold text-white shadow bg-rose-600';
                    }

                    // Action Container
                    const actionContainer = document.getElementById('modal-action-container');
                    if (data.sedang_meminjam) {
                        actionContainer.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-100 text-amber-800 text-xs font-bold">⏳ Sedang Kamu Pinjam</span>';
                    } else if (data.stok <= 0) {
                        actionContainer.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 text-gray-500 text-xs font-bold">Stok Belum Tersedia</span>';
                    } else if (!data.akun_aktif) {
                        actionContainer.innerHTML = '<span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-100 text-red-700 text-xs font-bold">Akun Belum Aktif</span>';
                    } else {
                        actionContainer.innerHTML = `
                            <form method="POST" action="${data.booking_url}">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
                                <input type="hidden" name="id_buku" value="${data.id_buku}">
                                <input type="hidden" name="durasi_pinjam" value="7">
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-[#0f4c3a] px-4 py-2 text-xs font-bold text-white shadow hover:bg-emerald-900 transition-colors">
                                    <span>Pinjam Sekarang (7 Hari)</span>
                                </button>
                            </form>
                        `;
                    }

                    modalLoading.classList.add('hidden');
                    modalContent.classList.remove('hidden');
                })
                .catch(function(err) {
                    modalLoading.innerHTML = '<p class="text-xs text-red-500 font-medium">Terjadi kesalahan saat memuat data buku.</p>';
                });
            };

            window.closeQuickPreview = function() {
                modalBox.classList.remove('scale-100', 'opacity-100');
                modalBox.classList.add('scale-95', 'opacity-0');
                setTimeout(function() {
                    modal.classList.add('hidden');
                }, 150);
            };

            // Backdrop click to close
            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', window.closeQuickPreview);
            }

            // Escape key to close
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    window.closeQuickPreview();
                }
            });

            // Init pagination binding
            bindPaginationLinks();
        })();

        // Alpine placeholder to satisfy x-data="katalogManager()"
        function katalogManager() {
            return {};
        }
    </script>
    @endpush
@endsection