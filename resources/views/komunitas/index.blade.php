@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10" x-data="komunitasApp()">

    {{-- Alert Flash Message --}}
    @if(session('success'))
        <div class="mb-5 flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-900 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-lg text-emerald-700 hover:bg-emerald-100 transition" aria-label="Tutup">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 flex items-center justify-between rounded-xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-900 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <p class="text-sm font-semibold">{{ session('error') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-lg text-rose-700 hover:bg-rose-100 transition" aria-label="Tutup">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- Hero Header Banner --}}
    <div class="mb-6 rounded-3xl bg-linear-to-r from-[#004236] via-[#0f4c3a] to-[#1a6650] p-6 sm:p-8 text-white shadow-md relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-52 h-52 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold backdrop-blur-sm mb-3">
                    <span class="inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Ruang Komunitas Literasi
                    </span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>Readify Social Space</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Bagikan Ulasan, Diskusi & Inspirasi Membaca
                </h1>
                <p class="mt-1 text-sm text-emerald-100 max-w-2xl leading-relaxed">
                    Terhubung dengan sesama penikmat buku, manga, novel, dan teknologi. Tautkan buku perpustakaan langsung ke dalam postinganmu!
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <div class="rounded-2xl bg-white/10 px-4 py-2.5 text-center backdrop-blur-sm border border-white/10">
                    <span class="text-xs text-emerald-200 block font-medium">Total Postingan</span>
                    <span class="text-xl font-black">{{ number_format($totalPostingan) }}</span>
                </div>
                <div class="rounded-2xl bg-white/10 px-4 py-2.5 text-center backdrop-blur-sm border border-white/10">
                    <span class="text-xs text-emerald-200 block font-medium">Komentar & Diskusi</span>
                    <span class="text-xl font-black">{{ number_format($totalKomentar) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid: Left Feed (2/3) + Right Sidebar (1/3) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ========================================================= --}}
        {{-- KOLOM KIRI: COMPOSER & FEED TIMELINE --}}
        {{-- ========================================================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- 1. Post Composer Box --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <form action="{{ route('komunitas.store') }}" method="POST" id="form-buat-post">
                    @csrf
                    
                    <div class="flex items-start gap-3">
                        {{-- Avatar Pengguna Saat Ini --}}
                        <div class="w-10 h-10 rounded-full bg-[#004236] text-white flex items-center justify-center font-bold text-sm shrink-0 overflow-hidden shadow-xs mt-1">
                            @if(Auth::user()->foto_profil)
                                <img src="{{ asset('storage/foto_profil/' . Auth::user()->foto_profil) }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->anggota->nama_lengkap ?? Auth::user()->nama_pengguna, 0, 2)) }}
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            {{-- Input Teks --}}
                            <textarea name="konten" rows="3" required
                                placeholder="Apa yang sedang kamu baca atau pikirkan hari ini? Bagikan ulasan, kutipan, atau pertanyaanmu..."
                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3.5 text-sm text-gray-900 outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15 resize-none">{{ old('konten') }}</textarea>

                            {{-- Pilihan Tipe Postingan (Pills) --}}
                            <div class="mt-3 flex items-center gap-2 flex-wrap">
                                <span class="text-xs font-bold text-gray-500 mr-1">Tipe:</span>
                                
                                <label class="cursor-pointer">
                                    <input type="radio" name="tipe" value="diskusi" class="hidden peer" checked x-model="tipePost">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border transition-all inline-flex items-center gap-1.5 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        Diskusi
                                    </span>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="tipe" value="review" class="hidden peer" x-model="tipePost">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border transition-all inline-flex items-center gap-1.5 peer-checked:bg-amber-500 peer-checked:text-white peer-checked:border-amber-500 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Review Buku
                                    </span>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="tipe" value="kutipan" class="hidden peer" x-model="tipePost">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border transition-all inline-flex items-center gap-1.5 peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-600 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                        Kutipan Favorit
                                    </span>
                                </label>

                                <label class="cursor-pointer">
                                    <input type="radio" name="tipe" value="rekomendasi" class="hidden peer" x-model="tipePost">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border transition-all inline-flex items-center gap-1.5 peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        Rekomendasi
                                    </span>
                                </label>
                            </div>

                            {{-- Input Rating Bintang (Hanya muncul jika tipe = review) --}}
                            <div x-show="tipePost === 'review'" x-cloak class="mt-3 flex items-center gap-2 p-2.5 rounded-xl bg-amber-50/70 border border-amber-200/70">
                                <span class="text-xs font-bold text-amber-900">Beri Rating:</span>
                                <div class="flex items-center gap-1">
                                    <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                        <button type="button" @click="ratingVal = star"
                                            class="p-1 focus:outline-none transition-transform hover:scale-125"
                                            :class="star <= ratingVal ? 'text-amber-500' : 'text-gray-300'">
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                                <input type="hidden" name="rating" :value="ratingVal">
                                <span class="text-xs font-semibold text-amber-800 ml-1" x-text="ratingVal + ' dari 5 Bintang'"></span>
                            </div>

                            {{-- Tautkan Buku Perpustakaan --}}
                            <div class="mt-3.5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 pt-3 border-t border-gray-100">
                                <div class="relative flex-1">
                                    <select name="id_buku" class="w-full text-xs rounded-xl border border-gray-200 bg-gray-50/60 px-3 py-2 text-gray-700 outline-none focus:border-[#004236] focus:bg-white">
                                        <option value="">Tautkan Buku Perpustakaan (Opsional)...</option>
                                        @foreach($daftarBuku as $b)
                                            <option value="{{ $b->id_buku }}" {{ request('buku_id') == $b->id_buku ? 'selected' : '' }}>
                                                {{ $b->judul_buku }} ({{ $b->penulis }}) • {{ $b->lokasi_rak ?? 'Rak Utama' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#004236] px-5 py-2.5 text-xs font-bold text-white shadow hover:bg-emerald-950 transition-colors shrink-0">
                                    <span>Bagikan</span>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. Filter & Search Bar Komunitas --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 rounded-2xl border border-gray-100 bg-white p-3 shadow-sm">
                {{-- Category Filter Pills --}}
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5">
                    @php
                        $curTipe = request('tipe', 'semua');
                    @endphp
                    <a href="{{ route('komunitas.index', array_merge(request()->except('tipe', 'page'), ['tipe' => 'semua'])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-bold shrink-0 transition {{ $curTipe === 'semua' ? 'bg-[#004236] text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('komunitas.index', array_merge(request()->except('tipe', 'page'), ['tipe' => 'diskusi'])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold shrink-0 transition inline-flex items-center gap-1 {{ $curTipe === 'diskusi' ? 'bg-blue-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Diskusi
                    </a>
                    <a href="{{ route('komunitas.index', array_merge(request()->except('tipe', 'page'), ['tipe' => 'review'])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold shrink-0 transition inline-flex items-center gap-1 {{ $curTipe === 'review' ? 'bg-amber-500 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Review
                    </a>
                    <a href="{{ route('komunitas.index', array_merge(request()->except('tipe', 'page'), ['tipe' => 'kutipan'])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold shrink-0 transition inline-flex items-center gap-1 {{ $curTipe === 'kutipan' ? 'bg-purple-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        Kutipan
                    </a>
                    <a href="{{ route('komunitas.index', array_merge(request()->except('tipe', 'page'), ['tipe' => 'rekomendasi'])) }}"
                        class="px-3 py-1.5 rounded-full text-xs font-semibold shrink-0 transition inline-flex items-center gap-1 {{ $curTipe === 'rekomendasi' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Rekomendasi
                    </a>
                </div>

                {{-- Sort Dropdown --}}
                <form method="GET" action="{{ route('komunitas.index') }}" class="flex items-center gap-2 shrink-0">
                    @if(request('tipe')) <input type="hidden" name="tipe" value="{{ request('tipe') }}"> @endif
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    
                    <select name="sort" onchange="this.form.submit()"
                        class="rounded-xl border border-gray-200 bg-gray-50/70 px-3 py-1.5 text-xs font-semibold text-gray-700 outline-none focus:border-[#004236]">
                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Paling Populer (Likes)</option>
                        <option value="diskusi_terbanyak" {{ request('sort') == 'diskusi_terbanyak' ? 'selected' : '' }}>Komentar Terbanyak</option>
                    </select>
                </form>
            </div>

            {{-- 3. Feed List of Posts --}}
            <div class="space-y-4">
                @forelse($postingan as $post)
                    @php
                        $userPost = $post->pengguna;
                        $namaUser = $userPost->anggota->nama_lengkap ?? $userPost->nama_pengguna;
                        $fotoUser = $userPost->foto_profil ? asset('storage/foto_profil/' . $userPost->foto_profil) : null;
                        $initials = strtoupper(substr($namaUser, 0, 2));
                        $isOwner = Auth::id() === $post->id_pengguna;
                        $isStaff = in_array(Auth::user()->level_akses, ['admin', 'petugas']);
                        $isLiked = $post->sudahDiLike(Auth::id());
                    @endphp

                    <article id="post-{{ $post->id_postingan }}" class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:shadow-md">
                        
                        {{-- Post Header --}}
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-[#004236] text-white flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden shadow-xs">
                                    @if($fotoUser)
                                        <img src="{{ $fotoUser }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="text-sm font-bold text-gray-900 truncate">{{ $namaUser }}</h4>
                                        @if($userPost->isAdmin())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800">Admin</span>
                                        @elseif($userPost->isPetugas())
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-800">Petugas</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">Anggota</span>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-0.5">{{ $post->waktu_lalu }}</p>
                                </div>
                            </div>

                            {{-- Post Type Badge & Delete Option --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $post->badge_tipe['class'] }}">
                                    {{ $post->badge_tipe['label'] }}
                                </span>

                                @if($isOwner || $isStaff)
                                    <form method="POST" action="{{ route('komunitas.destroy', $post->id_postingan) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition" title="Hapus Postingan">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        {{-- Rating Stars (if review) --}}
                        @if($post->tipe === 'review' && $post->rating)
                            <div class="flex items-center gap-1 mb-2 text-amber-500 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $post->rating)
                                        <svg class="w-4 h-4 fill-amber-400 text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @else
                                        <svg class="w-4 h-4 fill-none stroke-gray-300" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    @endif
                                @endfor
                                <span class="text-xs font-bold text-gray-600 ml-1.5">({{ $post->rating }}/5 Bintang)</span>
                            </div>
                        @endif

                        {{-- Post Content Body --}}
                        <div class="text-sm text-gray-800 leading-relaxed whitespace-pre-line mb-3">
                            {{ $post->konten }}
                        </div>

                        {{-- Tagged Book Card (Jika menautkan buku) --}}
                        @if($post->buku)
                            <div class="mb-4 rounded-xl border border-gray-200 bg-gray-50/80 p-3 hover:bg-emerald-50/40 transition flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-12 h-16 rounded-lg bg-gray-200 overflow-hidden shrink-0 shadow-xs">
                                        @if($post->buku->sampul)
                                            <img src="{{ Storage::url($post->buku->sampul) }}" alt="Cover" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-emerald-100 text-[#004236]">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <span class="text-[10px] font-bold text-[#004236] uppercase tracking-wider">
                                                {{ $post->buku->kategori->first()?->nama_kategori ?? 'Umum' }}
                                            </span>
                                            @if($post->buku->lokasi_rak)
                                                <span class="text-[9px] px-1.5 py-0.5 rounded bg-white text-gray-600 font-medium border border-gray-200 inline-flex items-center gap-1">
                                                    <svg class="w-2.5 h-2.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                    {{ $post->buku->lokasi_rak }}
                                                </span>
                                            @endif
                                        </div>
                                        <h5 class="text-xs sm:text-sm font-bold text-gray-900 truncate">
                                            {{ $post->buku->judul_buku }}
                                        </h5>
                                        <p class="text-[11px] text-gray-500 truncate">Penulis: {{ $post->buku->penulis }}</p>
                                    </div>
                                </div>

                                <div class="shrink-0 flex items-center gap-1.5">
                                    <a href="{{ route('anggota.buku.detail', $post->buku->id_buku) }}"
                                        class="rounded-lg bg-[#004236] px-3 py-1.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-950 transition">
                                        Pinjam / Detail
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons: Like & Komentar Bar --}}
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 text-xs">
                            <div class="flex items-center gap-4">
                                {{-- Like Button (AJAX) --}}
                                <button type="button" @click="toggleLike({{ $post->id_postingan }})"
                                    class="flex items-center gap-1.5 font-bold transition group"
                                    :class="isLiked({{ $post->id_postingan }}, {{ $isLiked ? 'true' : 'false' }}) ? 'text-rose-600' : 'text-gray-500 hover:text-rose-600'">
                                    <svg class="w-4 h-4 transition transform group-hover:scale-125" :fill="isLiked({{ $post->id_postingan }}, {{ $isLiked ? 'true' : 'false' }}) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    <span x-text="getLikesCount({{ $post->id_postingan }}, {{ $post->jumlah_like }}) + ' Suka'"></span>
                                </button>

                                {{-- Comment Toggle Button --}}
                                <button type="button" @click="toggleComments({{ $post->id_postingan }})"
                                    class="flex items-center gap-1.5 font-bold text-gray-500 hover:text-[#004236] transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>{{ $post->jumlah_komentar }} Komentar</span>
                                </button>
                            </div>

                            <span class="text-[11px] text-gray-400">Readify Community</span>
                        </div>

                        {{-- Comments Section (Collapsible) --}}
                        <div x-show="showComments[{{ $post->id_postingan }}]" x-cloak class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                            
                            {{-- Comments List --}}
                            <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                                @forelse($post->komentar as $kom)
                                    @php
                                        $komUser = $kom->pengguna;
                                        $namaKomUser = $komUser->anggota->nama_lengkap ?? $komUser->nama_pengguna;
                                        $canDeleteKom = Auth::id() === $kom->id_pengguna || $isOwner || $isStaff;
                                    @endphp
                                    <div class="flex items-start gap-2.5 rounded-xl bg-gray-50/70 p-2.5 text-xs">
                                        <div class="w-7 h-7 rounded-full bg-[#004236] text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                                            {{ strtoupper(substr($namaKomUser, 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between gap-1">
                                                <span class="font-bold text-gray-900">{{ $namaKomUser }}</span>
                                                <span class="text-[10px] text-gray-400">{{ $kom->waktu_lalu }}</span>
                                            </div>
                                            <p class="text-gray-700 mt-0.5 leading-relaxed whitespace-pre-line">{{ $kom->konten }}</p>
                                        </div>
                                        @if($canDeleteKom)
                                            <form method="POST" action="{{ route('komunitas.komentar.destroy', $kom->id_komentar) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-6 h-6 flex items-center justify-center rounded text-gray-400 hover:text-red-500 hover:bg-red-50 transition" title="Hapus Komentar">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-center text-xs text-gray-400 py-2">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                                @endforelse
                            </div>

                            {{-- Add Comment Form --}}
                            <form action="{{ route('komunitas.komentar.store', $post->id_postingan) }}" method="POST" class="flex items-center gap-2 pt-2">
                                @csrf
                                <input type="text" name="konten" required placeholder="Tulis tanggapan atau komentar..."
                                    class="flex-1 rounded-xl border border-gray-200 bg-gray-50/60 px-3.5 py-2 text-xs outline-none focus:border-[#004236] focus:bg-white">
                                <button type="submit" class="rounded-xl bg-[#004236] px-4 py-2 text-xs font-bold text-white hover:bg-emerald-950 transition shrink-0">
                                    Kirim
                                </button>
                            </form>
                        </div>

                    </article>
                @empty
                    <div class="rounded-2xl border border-gray-100 bg-white p-12 text-center shadow-sm">
                        <div class="mx-auto w-16 h-16 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center mb-3">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Belum ada postingan</h3>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">Mulai diskusi pertama atau bagikan ulasan buku favoritmu sekarang!</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-6">
                {{ $postingan->links() }}
            </div>

        </div>

        {{-- ========================================================= --}}
        {{-- KOLOM KANAN: SIDEBAR WIDGETS --}}
        {{-- ========================================================= --}}
        <div class="space-y-6">

            {{-- 1. Widget Buku Paling Ramai Dibicarakan --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.527.82-1.157 2.155-.788 3.708.077.324.088.66.012.98a4.004 4.004 0 01-.645 1.378c-.287.41-.67.75-1.11 1.002-.44.252-.942.392-1.45.41a3.003 3.003 0 01-2.456-1.157c-.244-.318-.415-.69-.5-1.094a1 1 0 00-1.924.526 5.008 5.008 0 001.218 2.378c.84.99 2.025 1.637 3.325 1.815.347.047.697.067 1.047.06.842-.016 1.68-.216 2.454-.593.774-.378 1.458-.934 1.996-1.625.538-.69.89-1.503 1.026-2.372.135-.87.037-1.758-.288-2.593a8.03 8.03 0 00-1.127-1.992zM6.5 14a4.5 4.5 0 004.5 4.5c1.47 0 2.8-.71 3.63-1.8.19-.25.33-.53.42-.83a5.52 5.52 0 00.45-2.22c0-.57-.08-1.12-.24-1.64a5.98 5.98 0 01-1.76 1.99c-.6.44-1.32.72-2.07.82-.75.09-1.52-.01-2.22-.3a3.52 3.52 0 01-1.71-1.52A4.47 4.47 0 006.5 14z" clip-rule="evenodd"/></svg>
                        <h3 class="text-sm font-bold text-gray-900">Buku Paling Ramai</h3>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Trending</span>
                </div>

                <div class="space-y-3">
                    @forelse($bukuTrending as $bt)
                        <a href="{{ route('komunitas.index', ['buku_id' => $bt->id_buku]) }}"
                            class="group flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                            <div class="w-10 h-14 rounded-lg bg-gray-100 overflow-hidden shrink-0 shadow-xs">
                                @if($bt->sampul)
                                    <img src="{{ Storage::url($bt->sampul) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-[#004236]">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs font-bold text-gray-900 truncate group-hover:text-[#004236] transition">
                                    {{ $bt->judul_buku }}
                                </h4>
                                <p class="text-[11px] text-gray-500 truncate">{{ $bt->penulis }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-semibold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded inline-flex items-center gap-1">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        {{ $bt->postingan_komunitas_count }} diskusi
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada buku yang ditautkan</p>
                    @endforelse
                </div>
            </div>

            {{-- 2. Widget Top Kontributor Komunitas --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 011.395 1.189l-1.5 6A1 1 0 0115.5 13H4.5a1 1 0 01-.948-.694l-1.5-6a1 1 0 011.395-1.189l1.599.8L9 4.323V3a1 1 0 011-1zm-5 13a1 1 0 000 2h10a1 1 0 100-2H5z" clip-rule="evenodd"/></svg>
                        <h3 class="text-sm font-bold text-gray-900">Top Kontributor</h3>
                    </div>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Aktif</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($topKontributor as $idx => $kontributor)
                        <div class="flex items-center justify-between p-2 rounded-xl bg-gray-50/70">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span class="w-5 text-center font-extrabold text-xs {{ $idx === 0 ? 'text-amber-500' : ($idx === 1 ? 'text-gray-400' : 'text-amber-700') }}">
                                    #{{ $idx + 1 }}
                                </span>
                                <div class="w-8 h-8 rounded-full bg-[#004236] text-white flex items-center justify-center text-xs font-bold shrink-0 overflow-hidden">
                                    @if($kontributor->foto_profil)
                                        <img src="{{ asset('storage/foto_profil/' . $kontributor->foto_profil) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($kontributor->anggota->nama_lengkap ?? $kontributor->nama_pengguna, 0, 2)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-gray-900 truncate">
                                        {{ $kontributor->anggota->nama_lengkap ?? $kontributor->nama_pengguna }}
                                    </p>
                                    <p class="text-[10px] text-gray-500">{{ $kontributor->postingan_komunitas_count }} postingan</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada kontributor</p>
                    @endforelse
                </div>
            </div>

            {{-- 3. Panduan Etika Komunitas --}}
            <div class="rounded-2xl border border-gray-100 bg-linear-to-b from-gray-50 to-white p-5 shadow-sm text-xs text-gray-600 space-y-2">
                <div class="flex items-center gap-2 text-gray-900 font-bold mb-1">
                    <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    <span>Etika Berkomunitas</span>
                </div>
                <p>• Berikan review jujur tanpa spoiler cerita utama.</p>
                <p>• Saling menghargai preferensi genre membaca sesama anggota.</p>
                <p>• Tautkan buku agar teman-teman bisa langsung menemukan lokasinya di katalog perpustakaan.</p>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function komunitasApp() {
        return {
            tipePost: 'diskusi',
            ratingVal: 5,
            showComments: {},
            likesState: {},
            likesCountState: {},

            toggleComments(id) {
                this.showComments[id] = !this.showComments[id];
            },

            isLiked(id, initialLiked) {
                if (typeof this.likesState[id] === 'undefined') {
                    this.likesState[id] = initialLiked;
                }
                return this.likesState[id];
            },

            getLikesCount(id, initialCount) {
                if (typeof this.likesCountState[id] === 'undefined') {
                    this.likesCountState[id] = initialCount;
                }
                return this.likesCountState[id];
            },

            toggleLike(id) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                
                // Optimistic UI update
                const currentStatus = this.isLiked(id, false);
                const currentCount = this.getLikesCount(id, 0);

                this.likesState[id] = !currentStatus;
                this.likesCountState[id] = !currentStatus ? currentCount + 1 : Math.max(0, currentCount - 1);

                fetch('/komunitas/' + id + '/like', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.likesState[id] = data.liked;
                        this.likesCountState[id] = data.likes_count;
                    }
                })
                .catch(() => {
                    // Revert if error
                    this.likesState[id] = currentStatus;
                    this.likesCountState[id] = currentCount;
                });
            }
        };
    }
</script>
@endpush
@endsection
