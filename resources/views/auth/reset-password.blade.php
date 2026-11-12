@extends('layouts.auth')

@section('content')
<div class="p-6 sm:p-10 max-w-lg mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition min-h-[36px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Login</span>
        </a>

        <img src="{{ asset('img/Logo.svg') }}" class="h-6 w-auto" alt="Readify">
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">
            Reset Kata Sandi
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Buat kata sandi baru untuk akun <strong>{{ $email }}</strong>.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-2xs">
            <ul class="text-xs space-y-0.5 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group mb-0">
            <label for="email" class="form-label text-xs sm:text-sm font-bold text-gray-800">Email</label>
            <input type="email" name="email" id="email" class="form-control-glass text-xs sm:text-sm min-h-[46px]" value="{{ $email ?? old('email') }}"
                required readonly style="background: rgba(0,0,0,0.04);">
        </div>

        <div class="form-group mb-0">
            <label for="kata_sandi" class="form-label text-xs sm:text-sm font-bold text-gray-800">Kata Sandi Baru</label>
            <input type="password" name="kata_sandi" id="kata_sandi" class="form-control-glass text-xs sm:text-sm min-h-[46px]" required autofocus placeholder="Minimal 8 karakter">
        </div>

        <div class="form-group mb-0">
            <label for="kata_sandi_confirmation" class="form-label text-xs sm:text-sm font-bold text-gray-800">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="kata_sandi_confirmation" id="kata_sandi_confirmation" class="form-control-glass text-xs sm:text-sm min-h-[46px]" required placeholder="Ulangi kata sandi baru">
        </div>

        <button type="submit" class="btn-primary-glass">
            <span>Simpan Kata Sandi Baru</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>
</div>
@endsection
