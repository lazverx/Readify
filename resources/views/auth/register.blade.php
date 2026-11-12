@extends('layouts.auth')

@section('content')
<div class="p-6 sm:p-10 max-w-2xl mx-auto" x-data="{
    showPassword: false,
    selectedCategories: [],
    toggleCat(id) {
        id = parseInt(id);
        const idx = this.selectedCategories.indexOf(id);
        if (idx === -1) {
            this.selectedCategories.push(id);
        } else {
            this.selectedCategories.splice(idx, 1);
        }
    }
}">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-gray-900 transition min-h-[36px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>{{ __('messages.back_to_home') }}</span>
        </a>

        <div class="text-right">
            <img src="{{ asset('img/Logo.svg') }}" class="h-6 w-auto ml-auto" alt="Readify">
        </div>
    </div>

    <div class="mb-6">
        <span class="text-xs font-bold text-[#004236] uppercase tracking-wider block mb-1">
            Readify Digital Library
        </span>
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
            {{ __('messages.register') }}
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            {{ __('messages.register_subtitle') }}
        </p>
    </div>

    {{-- Error Banners --}}
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

    @if (session('error'))
        <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-3.5 text-xs font-semibold text-rose-900">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Hidden Inputs for Preferred Categories --}}
        <template x-for="catId in selectedCategories" :key="catId">
            <input type="hidden" name="preferensi_kategori[]" :value="catId">
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group mb-0">
                <label for="nama_lengkap" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.full_name') }}
                </label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control-glass text-xs sm:text-sm min-h-[46px]"
                    value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap Anda">
            </div>

            <div class="form-group mb-0">
                <label for="nama_pengguna" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.username') }}
                </label>
                <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control-glass text-xs sm:text-sm min-h-[46px]"
                    value="{{ old('nama_pengguna') }}" required placeholder="username_unik">
            </div>

            <div class="form-group mb-0">
                <label for="email" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.email') }}
                </label>
                <input type="email" name="email" id="email" class="form-control-glass text-xs sm:text-sm min-h-[46px]"
                    value="{{ old('email') }}" required placeholder="email@domain.com">
            </div>

            <div class="form-group mb-0">
                <label for="nomor_telepon" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.phone') }}
                </label>
                <input type="tel" name="nomor_telepon" id="nomor_telepon" class="form-control-glass text-xs sm:text-sm min-h-[46px]"
                    value="{{ old('nomor_telepon') }}" required placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group mb-0 md:col-span-2">
                <label for="kata_sandi" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.password') }}
                </label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="kata_sandi" id="kata_sandi"
                        class="form-control-glass pr-10 text-xs sm:text-sm min-h-[46px]" required placeholder="Minimal 8 karakter">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 p-1 min-h-[32px] flex items-center justify-center">
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="form-group mb-0 md:col-span-2">
                <label for="alamat" class="form-label text-xs sm:text-sm font-bold text-gray-800">
                    {{ __('messages.address') }}
                </label>
                <textarea rows="2" name="alamat" id="alamat" class="form-control-glass text-xs sm:text-sm"
                    required placeholder="Alamat lengkap tempat tinggal">{{ old('alamat') }}</textarea>
            </div>
        </div>

        {{-- Optional: Initial Reading Preferences --}}
        @if(isset($kategoriSemua) && $kategoriSemua->isNotEmpty())
            <div class="pt-3 border-t border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs sm:text-sm font-bold text-gray-800">
                        Pilih Minat Genre Awal (Opsional)
                    </label>
                    <span class="text-[11px] text-gray-500">Bisa diubah nanti di profil</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($kategoriSemua as $kat)
                        <button type="button" @click="toggleCat({{ $kat->id_kategori }})"
                            class="px-3 py-1.5 rounded-xl text-xs font-semibold border transition-all inline-flex items-center gap-1.5"
                            :class="selectedCategories.includes({{ $kat->id_kategori }})
                                ? 'bg-[#004236] text-white border-[#004236]'
                                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                            <span x-show="selectedCategories.includes({{ $kat->id_kategori }})">&#10003;</span>
                            <span>{{ $kat->nama_kategori }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="pt-3">
            <button type="submit" class="btn-primary-glass">
                <span>{{ __('messages.register') }}</span>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>

        <div class="auth-footer text-center text-xs text-gray-500 mt-4">
            {{ __('messages.has_account') }}
            <a href="{{ route('login') }}" class="font-bold text-[#004236] hover:underline ml-1">
                {{ __('messages.login_here') }}
            </a>
        </div>
    </form>
</div>
@endsection
