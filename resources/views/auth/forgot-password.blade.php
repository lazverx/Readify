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
            Lupa Kata Sandi
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Masukkan email yang terdaftar. Kami akan mengirimkan tautan untuk mereset kata sandi Anda.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-3.5 text-xs font-semibold text-emerald-900">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-rose-900 shadow-2xs">
            <ul class="text-xs space-y-0.5 font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
        @csrf

        <div class="form-group mb-0">
            <label for="email" class="form-label text-xs sm:text-sm font-bold text-gray-800">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control-glass text-xs sm:text-sm min-h-[46px]" value="{{ old('email') }}"
                placeholder="contoh@email.com" required autofocus>
        </div>

        <button type="submit" class="btn-primary-glass">
            <span>Kirim Link Reset</span>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>
</div>
@endsection
