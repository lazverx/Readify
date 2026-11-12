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

<div class="grid grid-cols-1 lg:grid-cols-12 min-h-[620px]" x-data="{
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
    {{-- KOLOM KIRI: EDITORIAL BRANDING & SHOWCASE BUKU --}}
    {{-- ========================================================= --}}
    <div class="hidden lg:flex lg:col-span-5 bg-linear-to-br from-[#004236] via-[#0b4d3e] to-[#145a49] p-8 sm:p-10 text-white flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-56 h-56 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-56 h-56 bg-emerald-400/10 rounded-full blur-2xl pointer-events-none"></div>

        {{-- Top Branding --}}
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold backdrop-blur-xs mb-6 border border-white/10 text-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>{{ __('messages.login_hero_badge') }}</span>
            </div>

            <div class="mb-4">
                <img src="{{ asset('img/Logo.svg') }}" class="h-9 w-auto brightness-0 invert" alt="Readify">
            </div>

            <h2 class="text-2xl xl:text-3xl font-black tracking-tight leading-snug">
                {{ __('messages.login_hero_title') }}
            </h2>
            <p class="mt-2 text-xs sm:text-sm text-emerald-100/80 leading-relaxed">
                {{ __('messages.login_hero_desc') }}
            </p>
        </div>

        {{-- Middle: Buku Pilihan Hari Ini --}}
        @if(isset($bukuPilihan) && $bukuPilihan)
            <div class="relative z-10 my-6 rounded-2xl bg-white/10 p-3.5 border border-white/15 backdrop-blur-xs shadow-xs">
                <div class="flex items-center gap-1.5 text-[10px] font-bold text-amber-300 uppercase tracking-wider mb-2">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span>{{ __('messages.book_of_the_day') }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-12 h-16 rounded-lg overflow-hidden bg-white/20 shrink-0 shadow-2xs">
                        @if($bukuPilihan->sampul)
                            <img src="{{ Storage::url($bukuPilihan->sampul) }}" alt="{{ $bukuPilihan->judul_buku }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-white/10 text-emerald-200">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-950/60 text-emerald-200">
                            {{ $bukuPilihan->kategori->first()?->nama_kategori ?? 'Koleksi' }}
                        </span>
                        <h4 class="text-xs font-bold text-white truncate mt-1">{{ $bukuPilihan->judul_buku }}</h4>
                        <p class="text-[11px] text-emerald-200/80 truncate">{{ $bukuPilihan->penulis }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Bottom Metrics --}}
        <div class="relative z-10 pt-4 border-t border-white/10 grid grid-cols-3 gap-2 text-center">
            <div class="bg-white/5 rounded-xl py-2 px-1 border border-white/5">
                <span class="text-sm font-black block text-white">{{ number_format($totalKoleksi ?? 134) }}+</span>
                <span class="text-[10px] text-emerald-200 font-medium block">Koleksi Buku</span>
            </div>
            <div class="bg-white/5 rounded-xl py-2 px-1 border border-white/5">
                <span class="text-sm font-black block text-white">{{ number_format($totalAnggota ?? 40) }}+</span>
                <span class="text-[10px] text-emerald-200 font-medium block">Pembaca Aktif</span>
            </div>
            <div class="bg-white/5 rounded-xl py-2 px-1 border border-white/5">
                <span class="text-sm font-black block text-emerald-300">100%</span>
                <span class="text-[10px] text-emerald-200 font-medium block">Akses Digital</span>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- KOLOM KANAN: FORM MASUK (LOGIN) --}}
    {{-- ========================================================= --}}
    <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-between bg-white">
        
        {{-- Header Back Link & Mobile Logo --}}
        <div>
            <div class="flex items-center justify-between mb-6">
                <a href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition min-h-[36px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('messages.back_to_home') }}</span>
                </a>

                <div class="lg:hidden">
                    <img src="{{ asset('img/Logo.svg') }}" class="h-6 w-auto" alt="Readify">
                </div>
            </div>

            {{-- Title & Contextual Greeting --}}
            <div class="mb-6">
                <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
                    {{ $greeting }} &bull; Readify Library
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                    {{ __('messages.login') }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    {{ __('messages.login_subtitle') }}
                </p>
            </div>

            {{-- Error & Status Banners --}}
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-2xs">
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
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-xs font-semibold text-emerald-900 shadow-2xs">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Username / Email --}}
                <div class="form-group mb-0">
                    <label for="nama_pengguna" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                        {{ __('messages.username_or_email') }}
                    </label>
                    <div class="relative">
                        <input type="text" name="nama_pengguna" id="nama_pengguna" x-model="username" required autofocus
                            placeholder="nama_pengguna atau email@domain.com"
                            class="form-control-glass pr-10 text-xs sm:text-sm min-h-[46px]">
                        <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Password Input --}}
                <div class="form-group mb-0">
                    <div class="flex items-center justify-between mb-1">
                        <label for="kata_sandi" class="form-label text-xs sm:text-sm font-bold text-gray-800 mb-0">
                            {{ __('messages.password') }}
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-[#004236] hover:underline">
                            {{ __('messages.forgot_password') }}
                        </a>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="kata_sandi" id="kata_sandi" x-model="password" required
                            @keyup="capsLockOn = $event.getModifierState('CapsLock')"
                            placeholder="••••••••"
                            class="form-control-glass pr-10 text-xs sm:text-sm min-h-[46px]">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 min-h-[32px] p-1 flex items-center justify-center" aria-label="Toggle password">
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
                    <div x-show="capsLockOn" x-cloak class="mt-1 flex items-center gap-1 text-[11px] font-bold text-amber-700">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ __('messages.caps_lock_active') }}</span>
                    </div>
                </div>

                {{-- Remember Me Checkbox --}}
                <div class="flex items-center pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="ingat_saya" id="ingat_saya"
                            class="w-4 h-4 rounded text-[#004236] focus:ring-[#004236] border-gray-300">
                        <span class="text-xs font-semibold text-gray-700">{{ __('messages.remember_me') }}</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="btn-primary-glass">
                        <span>{{ __('messages.login') }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Bottom Area: Quick Demo Selector & Register Link --}}
        <div class="mt-6 pt-5 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <span class="text-xs font-bold text-gray-500">{{ __('messages.quick_demo_login') }}</span>
                <div class="flex items-center gap-1.5 flex-wrap">
                    <button type="button" @click="fillDemo('admin@readify.id', 'admin123')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-rose-50 text-rose-800 border border-rose-200 hover:bg-rose-100 transition min-h-[32px]">
                        {{ __('messages.demo_admin') }}
                    </button>
                    <button type="button" @click="fillDemo('petugas@readify.id', 'petugas123')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200 hover:bg-blue-100 transition min-h-[32px]">
                        {{ __('messages.demo_officer') }}
                    </button>
                    <button type="button" @click="fillDemo('anggota@readify.id', 'anggota123')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition min-h-[32px]">
                        {{ __('messages.demo_member') }}
                    </button>
                </div>
            </div>

            <div class="text-center text-xs text-gray-500 mt-4">
                {{ __('messages.no_account') }}
                <a href="{{ route('register') }}" class="font-bold text-[#004236] hover:underline ml-1">
                    {{ __('messages.register_here') }}
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
