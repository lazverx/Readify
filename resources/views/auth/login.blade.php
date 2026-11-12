@extends('layouts.auth')

@section('content')
@php
    $jam = (int) date('H');
    $greeting = match(true) {
        $jam >= 5 && $jam < 12 => __('messages.greeting_morning'),
        $jam >= 12 && $jam < 15 => __('messages.greeting_afternoon'),
        $jam >= 15 && $jam < 18 => __('messages.greeting_evening'),
        default => __('messages.greeting_night'),
    };
@endphp

<div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-12 bg-white" x-data="{
    username: '{{ old('nama_pengguna') }}',
    password: '',
    showPassword: false,
    capsLockOn: false,
    fillDemo(u, p) {
        this.username = u;
        this.password = p;
    }
}">

    {{-- ========================================================= --}}
    {{-- SISI KIRI (55% FULL-PAGE BLEED 100VH): EDITORIAL SHOWCASE --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:flex lg:col-span-6 xl:col-span-7 min-h-screen flex-col justify-between p-12 xl:p-16 relative overflow-hidden bg-[#004236] text-white">
        {{-- Background Image with Deep Emerald Overlay --}}
        <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('/img/bg-auth.jpg');"></div>
        <div class="absolute inset-0 z-0 bg-linear-to-br from-[#002821] via-[#004236]/90 to-[#0b4d3e]/95"></div>
        <div class="absolute -right-24 -bottom-24 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none z-0"></div>

        {{-- Top Branding --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('img/Logo.svg') }}" class="h-10 w-auto brightness-0 invert" alt="Readify">
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/10 text-emerald-300 border border-white/15 backdrop-blur-xs">
                    Perpustakaan Digital
                </span>
            </div>

            <h2 class="text-3xl xl:text-5xl font-black tracking-tight leading-tight max-w-xl">
                Jelajahi Dunia Lewat Setiap Lembar Buku.
            </h2>
            <p class="mt-4 text-sm xl:text-base text-emerald-100/80 leading-relaxed max-w-lg">
                Masuk ke ruang baca pribadi Anda untuk meminjam koleksi pilihan, melacak target membaca, dan menikmati rekomendasi terkurasi.
            </p>
        </div>

        {{-- Middle: Buku Pilihan Hari Ini (Showcase) --}}
        @if(isset($bukuPilihan) && $bukuPilihan)
            <div class="relative z-10 my-8 max-w-lg rounded-2xl bg-white/10 p-4 border border-white/15 backdrop-blur-md shadow-md">
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-amber-300 uppercase tracking-wider mb-2.5">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>Buku Pilihan Hari Ini</span>
                </div>

                <div class="flex items-center gap-3.5">
                    <div class="w-14 h-20 rounded-lg overflow-hidden bg-white/20 shrink-0 shadow-sm">
                        @if($bukuPilihan->sampul)
                            <img src="{{ Storage::url($bukuPilihan->sampul) }}" alt="{{ $bukuPilihan->judul_buku }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-white/10 text-emerald-200">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-emerald-950/70 text-emerald-200 inline-block mb-1">
                            {{ $bukuPilihan->kategori->first()?->nama_kategori ?? 'Koleksi Perpustakaan' }}
                        </span>
                        <h4 class="text-sm font-bold text-white truncate">{{ $bukuPilihan->judul_buku }}</h4>
                        <p class="text-xs text-emerald-200/80 truncate">{{ $bukuPilihan->penulis }}</p>
                        <p class="text-[11px] text-emerald-300/90 mt-1 font-semibold">
                            Lokasi Rak: {{ $bukuPilihan->lokasi_rak ?? 'Rak Utama' }} &bull; Stok: {{ $bukuPilihan->stok }} eks
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bottom Metrics --}}
        <div class="relative z-10 pt-6 border-t border-white/15 grid grid-cols-3 gap-4 max-w-lg">
            <div>
                <span class="text-xl xl:text-2xl font-black block text-white">{{ number_format($totalKoleksi ?? 134) }}+</span>
                <span class="text-xs text-emerald-200/80 font-medium block">Koleksi Judul</span>
            </div>
            <div>
                <span class="text-xl xl:text-2xl font-black block text-white">{{ number_format($totalAnggota ?? 40) }}+</span>
                <span class="text-xs text-emerald-200/80 font-medium block">Pembaca Aktif</span>
            </div>
            <div>
                <span class="text-xl xl:text-2xl font-black block text-emerald-300">100%</span>
                <span class="text-xs text-emerald-200/80 font-medium block">Akses Digital</span>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- SISI KANAN (45% FULL-PAGE BLEED 100VH): FORM LOGIN BERSIH --}}
    {{-- ========================================================= --}}
    <div class="lg:col-span-6 xl:col-span-5 min-h-screen flex items-center justify-center p-6 sm:p-12 xl:p-16 bg-white overflow-y-auto">
        <div class="w-full max-w-md mx-auto my-auto py-8">
            
            {{-- Top Navigation & Mobile Brand --}}
            <div class="flex items-center justify-between mb-8">
                <a href="/" class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-gray-900 transition min-h-[36px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('messages.back_to_home') }}</span>
                </a>

                <div class="lg:hidden">
                    <img src="{{ asset('img/Logo.svg') }}" class="h-7 w-auto" alt="Readify">
                </div>
            </div>

            {{-- Heading & Greeting --}}
            <div class="mb-7">
                <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                    {{ $greeting }} &bull; Readify
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    Masuk ke Akun Anda
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    Masukkan username atau email terdaftar untuk melanjutkan.
                </p>
            </div>

            {{-- Error Banners --}}
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

            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-semibold text-emerald-900">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Username / Email Input --}}
                <div>
                    <label for="nama_pengguna" class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                        {{ __('messages.username_or_email') }}
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_pengguna" id="nama_pengguna" x-model="username" required autofocus
                            placeholder="nama_pengguna atau email@readify.id"
                            class="auth-input pr-10 text-xs sm:text-sm min-h-[48px]">
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Password Input --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="kata_sandi" class="block text-xs sm:text-sm font-bold text-gray-800">
                            {{ __('messages.password') }}
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#004236] hover:underline">
                            {{ __('messages.forgot_password') }}
                        </a>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="kata_sandi" id="kata_sandi" x-model="password" required
                            @keyup="capsLockOn = $event.getModifierState('CapsLock')"
                            placeholder="••••••••"
                            class="auth-input pr-10 text-xs sm:text-sm min-h-[48px]">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 min-h-[36px] p-1 flex items-center justify-center" aria-label="Toggle password">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    {{-- Caps Lock Indicator --}}
                    <div x-show="capsLockOn" x-cloak class="mt-1.5 flex items-center gap-1.5 text-xs font-bold text-amber-700">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Caps Lock sedang aktif</span>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center pt-1">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" name="ingat_saya" id="ingat_saya"
                            class="w-4 h-4 rounded text-[#004236] focus:ring-[#004236] border-gray-300">
                        <span class="text-xs font-semibold text-gray-700">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="auth-btn-primary">
                        <span>{{ __('messages.login') }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Bottom: Quick Demo Pills & Register --}}
            <div class="mt-8 pt-6 border-t border-gray-100 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                    <span class="text-xs font-bold text-gray-500">Akses Cepat Demo:</span>
                    <div class="flex items-center gap-1.5 flex-wrap">
                        <button type="button" @click="fillDemo('admin@readify.id', 'admin123')"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-50 text-rose-800 border border-rose-200 hover:bg-rose-100 transition min-h-[32px]">
                            Admin
                        </button>
                        <button type="button" @click="fillDemo('petugas@readify.id', 'petugas123')"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 hover:bg-blue-100 transition min-h-[32px]">
                            Petugas
                        </button>
                        <button type="button" @click="fillDemo('anggota@readify.id', 'anggota123')"
                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition min-h-[32px]">
                            Anggota
                        </button>
                    </div>
                </div>

                <div class="text-center text-xs text-gray-500 pt-2">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-bold text-[#004236] hover:underline ml-1">
                        Daftar akun sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
