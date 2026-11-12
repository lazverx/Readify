@extends('layouts.auth')

@section('content')
@php
    $categoryIcons = [
        'Fiksi' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>',
        'Sains' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>',
        'Sejarah' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'Teknologi' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',
        'Seni' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c.7 0 1.34.18 1.9.5A7.002 7.002 0 0117.89 4.67a1 1 0 011.44 1.44 7 7 0 01-1.93 11.23c.32.56.5 1.2.5 1.9a4 4 0 01-4 4H7z" /></svg>',
        'Biografi' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
        'Bisnis' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>',
        'Anak-anak' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        'Manga' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>',
        'Novel' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>',
        'Filosofi' => '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>',
    ];

    $categoriesMap = [];
    foreach ($kategoriSemua as $kat) {
        $categoriesMap[$kat->id_kategori] = $kat->nama_kategori;
    }

    $starterBooksData = [];
    if (isset($bukuStarter)) {
        foreach ($bukuStarter as $buku) {
            $starterBooksData[] = [
                'id_buku' => $buku->id_buku,
                'judul' => $buku->judul_buku,
                'penulis' => $buku->penulis,
                'sampul' => $buku->sampul ? Storage::url($buku->sampul) : null,
                'kategori_ids' => $buku->kategori->pluck('id_kategori')->toArray(),
                'kategori_nama' => $buku->kategori->first()?->nama_kategori ?? 'Koleksi',
            ];
        }
    }
@endphp

<div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-white" x-data="{
    step: 1,
    submitting: false,
    showPassword: false,
    capsLockOn: false,
    formData: {
        nama_lengkap: '{{ old('nama_lengkap', '') }}',
        nama_pengguna: '{{ old('nama_pengguna', '') }}',
        email: '{{ old('email', '') }}',
        nomor_telepon: '{{ old('nomor_telepon', '') }}',
        kata_sandi: '',
        alamat: `{{ old('alamat', '') }}`
    },
    selectedCategories: {{ json_encode(array_map('intval', old('preferensi_kategori', []))) }},
    starterBooks: {{ json_encode(array_map('intval', old('starter_books', []))) }},
    readingGoal: {{ (int) old('target_baca_bulanan', 3) }},
    activeCategoryFilter: 'all',
    allBooks: {{ json_encode($starterBooksData) }},
    categoriesMap: {{ json_encode($categoriesMap) }},
    errorMessage: '',

    validateStep1() {
        if (!this.formData.nama_lengkap.trim()) return 'Nama lengkap wajib diisi.';
        if (!this.formData.nama_pengguna.trim()) return 'Nama pengguna wajib diisi.';
        if (!this.formData.email.trim() || !this.formData.email.includes('@')) return 'Email valid wajib diisi.';
        if (!this.formData.nomor_telepon.trim()) return 'Nomor telepon wajib diisi.';
        if (!this.formData.kata_sandi || this.formData.kata_sandi.length < 8) return 'Kata sandi minimal 8 karakter.';
        if (!this.formData.alamat.trim()) return 'Alamat tinggal wajib diisi.';
        return null;
    },

    nextToStep2() {
        const err = this.validateStep1();
        if (err) {
            this.errorMessage = err;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        this.errorMessage = '';
        this.step = 2;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    nextToStep3() {
        if (this.selectedCategories.length < 3) {
            this.errorMessage = 'Pilih minimal 3 topik bacaan sebelum melanjutkan.';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        this.errorMessage = '';
        this.step = 3;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    nextToStep4() {
        this.errorMessage = '';
        this.step = 4;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    prevStep() {
        this.errorMessage = '';
        if (this.step > 1) {
            this.step--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    toggleCat(id) {
        id = parseInt(id);
        const idx = this.selectedCategories.indexOf(id);
        if (idx === -1) {
            this.selectedCategories.push(id);
        } else {
            this.selectedCategories.splice(idx, 1);
        }
    },

    toggleBook(id) {
        id = parseInt(id);
        const idx = this.starterBooks.indexOf(id);
        if (idx === -1) {
            this.starterBooks.push(id);
        } else {
            this.starterBooks.splice(idx, 1);
        }
    },

    get filteredBooks() {
        if (this.activeCategoryFilter === 'all') {
            return this.allBooks;
        }
        const catId = parseInt(this.activeCategoryFilter);
        return this.allBooks.filter(b => b.kategori_ids.includes(catId));
    },

    getSelectedCategoryNames() {
        return this.selectedCategories.map(id => this.categoriesMap[id] || 'Kategori #' + id);
    },

    submitForm() {
        const err = this.validateStep1();
        if (err) {
            this.step = 1;
            this.errorMessage = err;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        if (this.selectedCategories.length < 3) {
            this.step = 2;
            this.errorMessage = 'Pilih minimal 3 topik bacaan.';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        this.submitting = true;
        document.getElementById('registerForm').submit();
    }
}">

    {{-- ========================================================= --}}
    {{-- SISI KIRI (40% DESKTOP): EDITORIAL ONBOARDING JOURNEY     --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:flex lg:col-span-4 xl:col-span-4 min-h-screen flex-col justify-between p-8 xl:p-12 relative overflow-hidden bg-[#004236] text-white">
        {{-- Background Image with Deep Emerald Overlay --}}
        <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('/img/bg-auth.jpg');"></div>
        <div class="absolute inset-0 z-0 bg-linear-to-br from-[#002821] via-[#004236]/95 to-[#0b4d3e]/95"></div>
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/5 rounded-full blur-3xl pointer-events-none z-0"></div>

        {{-- Top Branding --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('img/Logo.svg') }}" class="h-9 w-auto brightness-0 invert" alt="Readify">
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/10 text-emerald-300 border border-white/15 backdrop-blur-xs">
                    Personalisasi Akun
                </span>
            </div>

            <h2 class="text-2xl xl:text-3xl font-black tracking-tight leading-tight">
                Mulai Perjalanan Membaca yang Bermakna.
            </h2>
            <p class="mt-2 text-xs xl:text-sm text-emerald-100/80 leading-relaxed">
                Personalisasi preferensi Anda sekarang agar katalog, rekomendasi beranda, dan pustakawan cerdas selaras dengan minat baca Anda.
            </p>

            {{-- Stepper Progress List --}}
            <div class="mt-8 space-y-4">
                {{-- Step 1 --}}
                <div class="flex items-center gap-3.5 transition-all"
                    :class="step === 1 ? 'opacity-100' : (step > 1 ? 'opacity-90' : 'opacity-50')">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition-all"
                        :class="step > 1 ? 'bg-emerald-400 text-emerald-950 shadow-sm' : (step === 1 ? 'bg-white text-[#004236] font-black shadow-md' : 'bg-white/10 text-white/70 border border-white/20')">
                        <template x-if="step > 1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="step <= 1">
                            <span>1</span>
                        </template>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide uppercase">Kredensial Akun</h4>
                        <p class="text-[11px] text-emerald-200/80">Identitas diri & akses masuk</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="flex items-center gap-3.5 transition-all"
                    :class="step === 2 ? 'opacity-100' : (step > 2 ? 'opacity-90' : 'opacity-50')">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition-all"
                        :class="step > 2 ? 'bg-emerald-400 text-emerald-950 shadow-sm' : (step === 2 ? 'bg-white text-[#004236] font-black shadow-md' : 'bg-white/10 text-white/70 border border-white/20')">
                        <template x-if="step > 2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="step <= 2">
                            <span>2</span>
                        </template>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide uppercase">Minat & Topik Baca</h4>
                        <p class="text-[11px] text-emerald-200/80">Pilih minimal 3 kategori</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="flex items-center gap-3.5 transition-all"
                    :class="step === 3 ? 'opacity-100' : (step > 3 ? 'opacity-90' : 'opacity-50')">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition-all"
                        :class="step > 3 ? 'bg-emerald-400 text-emerald-950 shadow-sm' : (step === 3 ? 'bg-white text-[#004236] font-black shadow-md' : 'bg-white/10 text-white/70 border border-white/20')">
                        <template x-if="step > 3">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </template>
                        <template x-if="step <= 3">
                            <span>3</span>
                        </template>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide uppercase">Koleksi Awal</h4>
                        <p class="text-[11px] text-emerald-200/80">Buku pertama yang ingin dibaca</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="flex items-center gap-3.5 transition-all"
                    :class="step === 4 ? 'opacity-100' : 'opacity-50'">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition-all"
                        :class="step === 4 ? 'bg-white text-[#004236] font-black shadow-md' : 'bg-white/10 text-white/70 border border-white/20'">
                        <span>4</span>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide uppercase">Ritme Membaca</h4>
                        <p class="text-[11px] text-emerald-200/80">Komitmen target bacaan bulanan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Live Personalisasi Recap Box --}}
        <div class="relative z-10 my-6 rounded-2xl bg-white/10 p-4 border border-white/15 backdrop-blur-md shadow-md">
            <h4 class="text-xs font-bold text-emerald-200 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Ringkasan Preferensi</span>
            </h4>
            <div class="space-y-1.5 text-xs text-emerald-100/90 font-medium">
                <div class="flex items-center justify-between">
                    <span class="text-emerald-300">Minat Topik:</span>
                    <span class="font-bold text-white" x-text="selectedCategories.length + ' dipilih (min. 3)'"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-emerald-300">Buku Koleksi Awal:</span>
                    <span class="font-bold text-white" x-text="starterBooks.length + ' judul tersimpan'"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-emerald-300">Target Bulanan:</span>
                    <span class="font-bold text-white" x-text="readingGoal + ' buku / bulan'"></span>
                </div>
            </div>
        </div>

        {{-- Bottom Metric --}}
        <div class="relative z-10 pt-5 border-t border-white/15 flex items-center justify-between text-xs text-emerald-200/80 font-medium">
            <span>{{ number_format($totalKoleksi ?? 146) }}+ Judul Terkurasi</span>
            <span>&bull;</span>
            <span>{{ number_format($totalAnggota ?? 40) }}+ Pembaca Aktif</span>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- SISI KANAN (60% DESKTOP): FORM & WIZARD INTERAKTIF        --}}
    {{-- ========================================================= --}}
    <div class="lg:col-span-8 xl:col-span-8 min-h-screen flex flex-col justify-between p-6 sm:p-10 xl:p-12 bg-white overflow-y-auto">
        
        <div class="w-full max-w-3xl mx-auto">
            {{-- Top Bar Navigation --}}
            <div class="flex items-center justify-between pb-6 border-b border-gray-100 mb-8">
                <div class="flex items-center gap-3">
                    <a href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition min-h-[36px]">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Beranda</span>
                    </a>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs font-bold text-[#004236] uppercase tracking-wider">
                        Langkah <span x-text="step"></span> dari 4
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500 hidden sm:inline">{{ __('messages.has_account') }}</span>
                    <a href="{{ route('login') }}" class="text-xs font-bold text-[#004236] hover:underline px-3 py-1.5 rounded-lg border border-emerald-200 hover:bg-emerald-50 transition min-h-[36px] inline-flex items-center">
                        {{ __('messages.login_here') }}
                    </a>
                </div>
            </div>

            {{-- Horizontal Progress Bar --}}
            <div class="w-full bg-gray-100 h-2 rounded-full mb-8 overflow-hidden">
                <div class="bg-[#004236] h-full transition-all duration-300 ease-out"
                    :style="'width: ' + (step * 25) + '%'"></div>
            </div>

            {{-- Error Banners --}}
            <template x-if="errorMessage">
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-2xs flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-xs font-semibold" x-text="errorMessage"></span>
                    </div>
                    <button type="button" @click="errorMessage = ''" class="text-rose-500 hover:text-rose-800 text-xs font-bold p-1 min-h-[32px]">
                        Tutup
                    </button>
                </div>
            </template>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-2xs">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <ul class="text-xs space-y-0.5 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-xs font-semibold text-rose-900">
                    {{ session('error') }}
                </div>
            @endif

            {{-- The Master Form (Submits Everything) --}}
            <form id="registerForm" action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Hidden Form State --}}
                <input type="hidden" name="nama_lengkap" :value="formData.nama_lengkap">
                <input type="hidden" name="nama_pengguna" :value="formData.nama_pengguna">
                <input type="hidden" name="email" :value="formData.email">
                <input type="hidden" name="nomor_telepon" :value="formData.nomor_telepon">
                <input type="hidden" name="kata_sandi" :value="formData.kata_sandi">
                <input type="hidden" name="alamat" :value="formData.alamat">
                <input type="hidden" name="target_baca_bulanan" :value="readingGoal">

                {{-- Hidden Selected Categories --}}
                <template x-for="catId in selectedCategories" :key="catId">
                    <input type="hidden" name="preferensi_kategori[]" :value="catId">
                </template>

                {{-- Hidden Starter Books --}}
                <template x-for="bookId in starterBooks" :key="bookId">
                    <input type="hidden" name="starter_books[]" :value="bookId">
                </template>

                {{-- ========================================================= --}}
                {{-- LANGKAH 1: KREDENSIAL AKUN DASAR                          --}}
                {{-- ========================================================= --}}
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="mb-6">
                        <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                            Langkah 1 &bull; Akun Pengguna
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Buat Akun Anggota Readify
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Lengkapi identitas Anda untuk mendapatkan nomor anggota digital perpustakaan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="step1_nama_lengkap" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.full_name') }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="step1_nama_lengkap" x-model="formData.nama_lengkap" required
                                placeholder="Nama lengkap Anda" class="auth-input text-xs sm:text-sm min-h-[48px]">
                        </div>

                        <div>
                            <label for="step1_nama_pengguna" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.username') }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="step1_nama_pengguna" x-model="formData.nama_pengguna" required
                                placeholder="username_unik" class="auth-input text-xs sm:text-sm min-h-[48px]">
                        </div>

                        <div>
                            <label for="step1_email" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.email') }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" id="step1_email" x-model="formData.email" required
                                placeholder="email@readify.id" class="auth-input text-xs sm:text-sm min-h-[48px]">
                        </div>

                        <div>
                            <label for="step1_nomor_telepon" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.phone') }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" id="step1_nomor_telepon" x-model="formData.nomor_telepon" required
                                placeholder="08xxxxxxxxxx" class="auth-input text-xs sm:text-sm min-h-[48px]">
                        </div>

                        <div class="md:col-span-2">
                            <label for="step1_kata_sandi" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.password') }} <span class="text-rose-500">* (Min. 8 karakter)</span>
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="step1_kata_sandi" x-model="formData.kata_sandi" required
                                    @keyup="capsLockOn = $event.getModifierState('CapsLock')"
                                    placeholder="••••••••" class="auth-input pr-10 text-xs sm:text-sm min-h-[48px]">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 min-h-[36px] p-1 flex items-center justify-center">
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                            <template x-if="capsLockOn">
                                <span class="text-[11px] text-amber-600 font-semibold mt-1 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Caps Lock aktif
                                </span>
                            </template>
                        </div>

                        <div class="md:col-span-2">
                            <label for="step1_alamat" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                                {{ __('messages.address') }} <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="step1_alamat" rows="2" x-model="formData.alamat" required
                                placeholder="Alamat domisili lengkap untuk verifikasi keanggotaan" class="auth-input text-xs sm:text-sm"></textarea>
                        </div>
                    </div>

                    {{-- Next Button --}}
                    <div class="mt-8 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            Semua kolom bertanda bintang (*) wajib diisi.
                        </span>
                        <button type="button" @click="nextToStep2()"
                            class="px-6 py-3.5 rounded-xl font-bold text-sm bg-[#004236] text-white hover:bg-[#0f4c3a] transition-all shadow-md inline-flex items-center gap-2 min-h-[48px]">
                            <span>Lanjut: Pilih Minat Baca</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- LANGKAH 2: PERSONALISASI MINAT & TOPIK (X / PINTEREST STYLE)--}}
                {{-- ========================================================= --}}
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                            Langkah 2 &bull; Personalisasi Minat
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Apa yang Ingin Anda Baca?
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Pilih minimal 3 topik atau genre yang Anda sukai untuk mengaktifkan kurasi beranda otomatis.
                        </p>
                    </div>

                    {{-- Interactive Counter Badge --}}
                    <div class="mb-6 p-4 rounded-2xl border transition-all flex items-center justify-between"
                        :class="selectedCategories.length >= 3 ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-amber-50 border-amber-300 text-amber-900'">
                        <div class="flex items-center gap-2.5">
                            <template x-if="selectedCategories.length >= 3">
                                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                            <template x-if="selectedCategories.length < 3">
                                <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </template>
                            <div>
                                <span class="text-xs font-bold block"
                                    x-text="selectedCategories.length >= 3 ? 'Hebat! Anda telah memilih ' + selectedCategories.length + ' topik.' : 'Pilih minimal 3 topik (' + selectedCategories.length + '/3 dipilih)'"></span>
                                <span class="text-[11px] opacity-80"
                                    x-text="selectedCategories.length >= 3 ? 'Beranda dan AI Pustakawan Anda akan dioptimalkan berdasarkan pilihan ini.' : 'Semakin spesifik pilihan Anda, semakin akurat rekomendasi buku yang kami sajikan.'"></span>
                            </div>
                        </div>

                        <span class="text-xs font-black px-3 py-1 rounded-full shrink-0"
                            :class="selectedCategories.length >= 3 ? 'bg-emerald-200 text-emerald-900' : 'bg-amber-200 text-amber-900'"
                            x-text="selectedCategories.length + ' / 3'"></span>
                    </div>

                    {{-- Category Cards Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                        @foreach($kategoriSemua as $kat)
                            <button type="button" @click="toggleCat({{ $kat->id_kategori }})"
                                class="p-4 rounded-2xl border text-left transition-all relative flex flex-col justify-between min-h-[96px] group cursor-pointer"
                                :class="selectedCategories.includes({{ $kat->id_kategori }})
                                    ? 'bg-[#004236] text-white border-[#004236] shadow-md ring-2 ring-[#004236]/20'
                                    : 'bg-white text-gray-800 border-gray-200 hover:border-gray-300 hover:bg-gray-50/70'">
                                
                                <div class="flex items-center justify-between w-full">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                        :class="selectedCategories.includes({{ $kat->id_kategori }}) ? 'bg-white/20 text-emerald-200' : 'bg-emerald-50 text-[#004236]'">
                                        {!! $categoryIcons[$kat->nama_kategori] ?? '<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>' !!}
                                    </div>

                                    <div class="w-5 h-5 rounded-full flex items-center justify-center border transition-all"
                                        :class="selectedCategories.includes({{ $kat->id_kategori }}) ? 'bg-emerald-400 border-emerald-400 text-emerald-950' : 'border-gray-300 text-transparent'">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <h4 class="text-xs sm:text-sm font-bold tracking-tight"
                                        :class="selectedCategories.includes({{ $kat->id_kategori }}) ? 'text-white' : 'text-gray-900'">
                                        {{ $kat->nama_kategori }}
                                    </h4>
                                </div>
                            </button>
                        @endforeach
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="mt-8 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <button type="button" @click="prevStep()"
                            class="px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-gray-600 hover:text-gray-900 border border-gray-200 hover:bg-gray-50 transition min-h-[48px] inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke Akun</span>
                        </button>

                        <button type="button" @click="nextToStep3()"
                            :disabled="selectedCategories.length < 3"
                            class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm transition-all shadow-md inline-flex items-center gap-2 min-h-[48px]"
                            :class="selectedCategories.length >= 3 ? 'bg-[#004236] text-white hover:bg-[#0f4c3a] cursor-pointer' : 'bg-gray-200 text-gray-400 cursor-not-allowed'">
                            <span>Lanjut: Pilih Buku Awal</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- LANGKAH 3: PILIH BUKU PERTAMA (STARTER READING LIST)      --}}
                {{-- ========================================================= --}}
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                            Langkah 3 &bull; Koleksi Awal
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Buku Mana yang Ingin Anda Baca Pertama?
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Simpan buku yang menarik langsung ke Koleksi Pribadi Anda. Langkah ini dapat dilewati jika ingin menjelajahi katalog nanti.
                        </p>
                    </div>

                    {{-- Category Filter Bar --}}
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-5 no-scrollbar">
                        <button type="button" @click="activeCategoryFilter = 'all'"
                            class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all border min-h-[38px]"
                            :class="activeCategoryFilter === 'all'
                                ? 'bg-[#004236] text-white border-[#004236]'
                                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                            Semua Rekomendasi
                        </button>

                        <template x-for="catId in selectedCategories" :key="catId">
                            <button type="button" @click="activeCategoryFilter = catId"
                                class="px-3.5 py-1.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all border min-h-[38px]"
                                :class="activeCategoryFilter === catId
                                    ? 'bg-[#004236] text-white border-[#004236]'
                                    : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'"
                                x-text="categoriesMap[catId] || ('Kategori #' + catId)">
                            </button>
                        </template>
                    </div>

                    {{-- Starter Books Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 max-h-[480px] overflow-y-auto p-1">
                        <template x-for="buku in filteredBooks" :key="buku.id_buku">
                            <div class="rounded-2xl border p-3 flex flex-col justify-between transition-all bg-white hover:shadow-md"
                                :class="starterBooks.includes(buku.id_buku) ? 'border-[#004236] ring-1 ring-[#004236]' : 'border-gray-200'">
                                
                                <div>
                                    {{-- Book Cover --}}
                                    <div class="aspect-3/4 rounded-xl overflow-hidden bg-gray-100 mb-2.5 relative shadow-xs">
                                        <template x-if="buku.sampul">
                                            <img :src="buku.sampul" :alt="buku.judul" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!buku.sampul">
                                            <div class="w-full h-full flex flex-col items-center justify-center bg-emerald-50 text-[#004236] p-2 text-center">
                                                <svg class="w-8 h-8 opacity-40 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                                <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-800" x-text="buku.kategori_nama"></span>
                                            </div>
                                        </template>

                                        {{-- Saved Badge --}}
                                        <template x-if="starterBooks.includes(buku.id_buku)">
                                            <div class="absolute top-2 right-2 w-6 h-6 rounded-full bg-[#004236] text-white flex items-center justify-center shadow-md">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </template>
                                    </div>

                                    <span class="text-[10px] font-bold text-[#004236] bg-emerald-50 px-2 py-0.5 rounded-md inline-block mb-1 truncate max-w-full"
                                        x-text="buku.kategori_nama"></span>
                                    <h4 class="text-xs font-bold text-gray-900 line-clamp-2 leading-snug" x-text="buku.judul"></h4>
                                    <p class="text-[11px] text-gray-500 line-clamp-1 mt-0.5" x-text="buku.penulis"></p>
                                </div>

                                {{-- Toggle Button --}}
                                <button type="button" @click="toggleBook(buku.id_buku)"
                                    class="mt-3 w-full py-2 px-2.5 rounded-xl text-xs font-bold transition-all min-h-[44px] flex items-center justify-center gap-1.5"
                                    :class="starterBooks.includes(buku.id_buku)
                                        ? 'bg-[#004236] text-white'
                                        : 'bg-emerald-50 text-[#004236] hover:bg-emerald-100 border border-emerald-200'">
                                    <template x-if="starterBooks.includes(buku.id_buku)">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Tersimpan</span>
                                        </span>
                                    </template>
                                    <template x-if="!starterBooks.includes(buku.id_buku)">
                                        <span>+ Ingin Baca</span>
                                    </template>
                                </button>
                            </div>
                        </template>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="mt-8 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <button type="button" @click="prevStep()"
                            class="px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-gray-600 hover:text-gray-900 border border-gray-200 hover:bg-gray-50 transition min-h-[48px] inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke Minat</span>
                        </button>

                        <div class="flex items-center gap-2">
                            <button type="button" @click="nextToStep4()"
                                class="px-4 py-3 rounded-xl font-bold text-xs sm:text-sm text-gray-500 hover:text-gray-900 transition min-h-[48px]">
                                Lewati
                            </button>

                            <button type="button" @click="nextToStep4()"
                                class="px-6 py-3.5 rounded-xl font-bold text-xs sm:text-sm bg-[#004236] text-white hover:bg-[#0f4c3a] transition-all shadow-md inline-flex items-center gap-2 min-h-[48px]">
                                <span>Lanjut: Ritme Membaca</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- LANGKAH 4: RITME MEMBACA & FINAL RECAP                   --}}
                {{-- ========================================================= --}}
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="mb-6">
                        <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                            Langkah 4 &bull; Ritme Membaca
                        </span>
                        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Seberapa Sering Anda Ingin Membaca?
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            Tentukan komitmen target bulanan Anda. Ini akan menjadi indikator pencapaian membaca di profil Anda.
                        </p>
                    </div>

                    {{-- Reading Goal Options --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                        {{-- Santai (1-2) --}}
                        <button type="button" @click="readingGoal = 2"
                            class="p-5 rounded-2xl border text-left transition-all relative flex flex-col justify-between cursor-pointer"
                            :class="readingGoal === 2
                                ? 'bg-emerald-50/60 border-[#004236] ring-2 ring-[#004236]/20'
                                : 'bg-white border-gray-200 hover:border-gray-300'">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700">
                                        Santai
                                    </span>
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center border"
                                        :class="readingGoal === 2 ? 'bg-[#004236] border-[#004236] text-white' : 'border-gray-300 text-transparent'">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 tracking-tight">1-2 Buku</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Cocok untuk membangun konsistensi awal tanpa tekanan waktu.
                                </p>
                            </div>
                            <span class="text-[11px] font-bold text-[#004236] mt-4 block">Target: 2 buku / bulan</span>
                        </button>

                        {{-- Reguler (3-4) - Recommended --}}
                        <button type="button" @click="readingGoal = 3"
                            class="p-5 rounded-2xl border text-left transition-all relative flex flex-col justify-between cursor-pointer"
                            :class="readingGoal === 3
                                ? 'bg-emerald-50/60 border-[#004236] ring-2 ring-[#004236]/20'
                                : 'bg-white border-gray-200 hover:border-gray-300'">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#004236] text-white">
                                        Populer & Rekomendasi
                                    </span>
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center border"
                                        :class="readingGoal === 3 ? 'bg-[#004236] border-[#004236] text-white' : 'border-gray-300 text-transparent'">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 tracking-tight">3-4 Buku</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Ritme ideal bagi pembaca aktif untuk menyelesaikan 1 judul tiap pekan.
                                </p>
                            </div>
                            <span class="text-[11px] font-bold text-[#004236] mt-4 block">Target: 3 buku / bulan</span>
                        </button>

                        {{-- Ambisius (5+) --}}
                        <button type="button" @click="readingGoal = 5"
                            class="p-5 rounded-2xl border text-left transition-all relative flex flex-col justify-between cursor-pointer"
                            :class="readingGoal === 5
                                ? 'bg-emerald-50/60 border-[#004236] ring-2 ring-[#004236]/20'
                                : 'bg-white border-gray-200 hover:border-gray-300'">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                        Kutu Buku
                                    </span>
                                    <div class="w-5 h-5 rounded-full flex items-center justify-center border"
                                        :class="readingGoal === 5 ? 'bg-[#004236] border-[#004236] text-white' : 'border-gray-300 text-transparent'">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-black text-gray-900 tracking-tight">5+ Buku</h3>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    Tantangan literasi intensif bagi penikmat ilmu dan bacaan beragam.
                                </p>
                            </div>
                            <span class="text-[11px] font-bold text-[#004236] mt-4 block">Target: 5 buku / bulan</span>
                        </button>
                    </div>

                    {{-- Comprehensive Recap Card --}}
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/70 p-5 mb-8">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-4 h-4 text-[#004236]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                                Siap Menyiapkan Beranda Bacaan Anda
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="p-3 bg-white rounded-xl border border-gray-200/80">
                                <span class="text-gray-400 block text-[11px] font-semibold">Identitas Anggota</span>
                                <span class="font-bold text-gray-900 text-sm block mt-0.5" x-text="formData.nama_lengkap || '-'"></span>
                                <span class="text-gray-500 block text-[11px]" x-text="'@' + (formData.nama_pengguna || '-') + ' • ' + (formData.email || '-')"></span>
                            </div>

                            <div class="p-3 bg-white rounded-xl border border-gray-200/80">
                                <span class="text-gray-400 block text-[11px] font-semibold">Ritme & Koleksi Awal</span>
                                <span class="font-bold text-[#004236] text-sm block mt-0.5" x-text="readingGoal + ' Buku per Bulan'"></span>
                                <span class="text-gray-500 block text-[11px]" x-text="starterBooks.length + ' buku awal akan disimpan ke koleksi Anda'"></span>
                            </div>

                            <div class="sm:col-span-2 p-3 bg-white rounded-xl border border-gray-200/80">
                                <span class="text-gray-400 block text-[11px] font-semibold mb-1.5">Topik & Genre Terpilih</span>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="name in getSelectedCategoryNames()" :key="name">
                                        <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-[#004236] border border-emerald-200"
                                            x-text="name"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Navigation & Final Submit --}}
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <button type="button" @click="prevStep()" :disabled="submitting"
                            class="px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-gray-600 hover:text-gray-900 border border-gray-200 hover:bg-gray-50 transition min-h-[48px] inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Kembali ke Buku Awal</span>
                        </button>

                        <button type="button" @click="submitForm()" :disabled="submitting"
                            class="px-8 py-3.5 rounded-xl font-black text-sm bg-[#004236] text-white hover:bg-[#0f4c3a] transition-all shadow-lg hover:shadow-xl inline-flex items-center gap-2 min-h-[48px] cursor-pointer disabled:opacity-50">
                            <template x-if="!submitting">
                                <span class="inline-flex items-center gap-2">
                                    <span>Selesaikan & Buka Beranda Saya</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </span>
                            </template>
                            <template x-if="submitting">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                    <span>Menyiapkan Beranda Anda...</span>
                                </span>
                            </template>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 max-w-3xl mx-auto w-full">
            <span>&copy; {{ date('Y') }} Readify Digital Library. Hak cipta dilindungi.</span>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-gray-600 transition">Panduan</a>
                <a href="#" class="hover:text-gray-600 transition">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
