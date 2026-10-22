@extends('layouts.auth')

@section('content')
    <div class="mb-4">
        <a href="/" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <i class="bi bi-arrow-left"></i> {{ __('messages.back_to_home') }}
        </a>
    </div>
    <div class="auth-logo">
        <img src="{{ asset('img/Logo.svg') }}" class="custom-logo" alt="Logo Readify">
    </div>
    <p class="auth-subtitle">
        {{ __('messages.login_subtitle') }}
    </p>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        @if ($errors->any())
            <div
                style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div
                style="background: rgba(25, 135, 84, 0.1); border: 1px solid #198754; color: #198754; padding: 10px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
        @endif

        <div class="form-group">
            <label for="nama_pengguna" class="form-label">{{ __('messages.username_or_email') }}</label>
            <div class="relative">
                <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control-glass pe-10"
                    value="{{ old('nama_pengguna') }}" placeholder="" required>
                <i class="bi bi-envelope input-icon absolute top-1/2 right-4 -translate-y-1/2"></i>
            </div>
        </div>

        <div class="form-group" x-data="{ showPassword: false }">
            <label for="kata_sandi" class="form-label">{{ __('messages.password') }}</label>
            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" name="kata_sandi" id="kata_sandi"
                    class="form-control-glass pe-10" placeholder="" required>
                <i class="bi input-icon absolute top-1/2 right-4 -translate-y-1/2 cursor-pointer"
                    :class="showPassword ? 'bi-eye' : 'bi-eye-slash'" @click="showPassword = !showPassword"></i>
            </div>
            <div style="text-align: right; margin-top: 5px;">
                <a href="{{ route('password.request') }}"
                    style="font-size: 0.8rem; color: #3b82f6; text-decoration: none;">{{ __('messages.forgot_password') }}</a>
            </div>
        </div>

        <button type="submit" class="btn-primary-glass">{{ __('messages.login') }}</button>

        <div class="auth-footer">
            {{ __('messages.no_account') }} <a href="{{ route('register') }}">{{ __('messages.register_here') }}</a>
        </div>
    </form>
@endsection