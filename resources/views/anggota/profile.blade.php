@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl space-y-6" x-data="{
    activeTab: '{{ request('tab', 'preferensi') }}',
    showModal: false,
    showPassword: false,
    previewUrl: null,
    targetCount: {{ (int) ($anggota?->target_baca_bulanan ?? 3) }},
    selectedCategories: {{ json_encode((array) ($anggota?->preferensi_kategori ?? [])) }},
    toggleCategory(id) {
        id = parseInt(id);
        const index = this.selectedCategories.indexOf(id);
        if (index === -1) {
            this.selectedCategories.push(id);
        } else {
            this.selectedCategories.splice(index, 1);
        }
    },
    handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    }
}">

    {{-- Alert Flash Message --}}
    @if(session('success'))
        <div class="flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-900 shadow-xs">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-lg text-emerald-700 hover:bg-emerald-100 transition" aria-label="Tutup">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- 1. HERO HEADER: READER IDENTITY SHOWCASE --}}
    {{-- ========================================================= --}}
    <div class="relative overflow-hidden rounded-3xl bg-linear-to-r from-[#004236] via-[#0f4c3a] to-[#1a6650] p-6 sm:p-8 text-white shadow-md">
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            {{-- User Avatar & Info --}}
            <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                <div class="relative w-18 h-18 sm:w-20 sm:h-20 rounded-2xl overflow-hidden bg-white/10 border-2 border-white/20 shadow-md shrink-0">
                    <template x-if="previewUrl">
                        <img :src="previewUrl" alt="Preview Foto" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewUrl">
                        @if($user->foto_profil)
                            <img src="{{ asset('storage/foto_profil/' . $user->foto_profil) }}" alt="{{ $user->nama_pengguna }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center font-bold text-xl sm:text-2xl text-white bg-[#004236]">
                                {{ strtoupper(substr($anggota?->nama_lengkap ?? $user->nama_pengguna, 0, 2)) }}
                            </div>
                        @endif
                    </template>
                </div>

                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/15 text-emerald-200 backdrop-blur-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            {{ $anggota?->id_anggota ? 'ID: ' . $anggota->id_anggota : 'Anggota Perpustakaan' }}
                        </span>
                        @if($user->isActive())
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-400/20 text-emerald-200 border border-emerald-400/30">
                                {{ __('messages.id_card_verified') }}
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-400/20 text-amber-200 border border-amber-400/30">
                                {{ __('messages.id_card_pending_status') }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black text-white truncate">
                        {{ $anggota?->nama_lengkap ?? $user->nama_pengguna }}
                    </h1>
                    <p class="text-xs sm:text-sm text-emerald-100/80 truncate mt-0.5">
                        {{ '@' . $user->nama_pengguna }} &bull; {{ $user->email }}
                    </p>
                </div>
            </div>

            {{-- Metric Stats Cards --}}
            <div class="grid grid-cols-3 gap-2 sm:gap-3 w-full md:w-auto shrink-0 pt-4 md:pt-0 border-t border-white/10 md:border-0">
                <div class="rounded-2xl bg-white/10 px-3.5 py-2.5 text-center backdrop-blur-xs border border-white/10">
                    <span class="text-[10px] sm:text-xs text-emerald-200 block font-medium">{{ __('messages.profile_rank') }}</span>
                    <span class="text-base sm:text-xl font-black text-white">#{{ $userStats['rank'] ?? '-' }}</span>
                </div>
                <div class="rounded-2xl bg-white/10 px-3.5 py-2.5 text-center backdrop-blur-xs border border-white/10">
                    <span class="text-[10px] sm:text-xs text-emerald-200 block font-medium">{{ __('messages.profile_borrowed') }}</span>
                    <span class="text-base sm:text-xl font-black text-white">{{ $userStats['total_pinjam'] ?? 0 }}</span>
                </div>
                <div class="rounded-2xl bg-white/10 px-3.5 py-2.5 text-center backdrop-blur-xs border border-white/10">
                    <span class="text-[10px] sm:text-xs text-emerald-200 block font-medium">{{ __('messages.reading_goal_banner') }}</span>
                    <span class="text-base sm:text-xl font-black text-amber-300">{{ $bukuDibacaBulanIni }}/{{ $targetBaca }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- 2. TAB NAVIGATION BAR --}}
    {{-- ========================================================= --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar rounded-2xl border border-gray-100 bg-white p-2 shadow-xs">
        <button type="button" @click="activeTab = 'preferensi'"
            :class="activeTab === 'preferensi' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
            class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold transition-all shrink-0 min-h-[44px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
            <span>{{ __('messages.tab_preferences') }}</span>
        </button>

        <button type="button" @click="activeTab = 'profil'"
            :class="activeTab === 'profil' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
            class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold transition-all shrink-0 min-h-[44px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>{{ __('messages.tab_profile') }}</span>
        </button>

        <button type="button" @click="activeTab = 'prestasi'"
            :class="activeTab === 'prestasi' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
            class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold transition-all shrink-0 min-h-[44px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>{{ __('messages.tab_achievements') }}</span>
        </button>

        <button type="button" @click="activeTab = 'kartu'"
            :class="activeTab === 'kartu' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'"
            class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold transition-all shrink-0 min-h-[44px]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
            </svg>
            <span>{{ __('messages.tab_card') }}</span>
        </button>
    </div>

    {{-- ========================================================= --}}
    {{-- FORM UTAMA UNTUK UPDATE PROFIL & PREFERENSI --}}
    {{-- ========================================================= --}}
    <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data"
        @submit.prevent="showModal = true" id="form-update-profil">
        @csrf
        @method('PUT')

        {{-- Hidden Inputs for Dynamic Array of Preferred Categories --}}
        <template x-for="catId in selectedCategories" :key="catId">
            <input type="hidden" name="preferensi_kategori[]" :value="catId">
        </template>

        {{-- ========================================================= --}}
        {{-- TAB 1: MINAT & PERSONALISASI PEMBACA --}}
        {{-- ========================================================= --}}
        <div x-show="activeTab === 'preferensi'" x-cloak class="space-y-6">
            
            {{-- Guidance Card --}}
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-5 shadow-xs flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-xl bg-[#004236] text-white flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ __('messages.pref_title') }}</h3>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                        {{ __('messages.pref_desc') }}
                    </p>
                </div>
            </div>

            {{-- 1. Favorite Genres Selection --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-xs">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ __('messages.pref_genres_label') }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">{{ __('messages.pref_genres_hint') }}</p>
                    </div>
                    <span class="text-xs font-bold text-[#004236] bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200"
                        x-text="selectedCategories.length + ' dipilih'"></span>
                </div>

                <div class="mt-4 flex flex-wrap gap-2.5">
                    @forelse($kategoriSemua ?? [] as $kat)
                        <button type="button"
                            @click="toggleCategory({{ $kat->id_kategori }})"
                            class="px-4 py-2 rounded-xl text-xs font-bold border transition-all inline-flex items-center gap-2 min-h-[44px]"
                            :class="selectedCategories.includes({{ $kat->id_kategori }})
                                ? 'bg-[#004236] text-white border-[#004236] shadow-xs'
                                : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100'">
                            <span x-show="selectedCategories.includes({{ $kat->id_kategori }})" class="w-3.5 h-3.5 inline-flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span>{{ $kat->nama_kategori }}</span>
                        </button>
                    @empty
                        <p class="text-xs text-gray-400">Belum ada kategori buku di sistem.</p>
                    @endforelse
                </div>
            </div>

            {{-- 2. Monthly Reading Goal Tracker --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ __('messages.pref_reading_goal') }}</h4>
                        <p class="text-xs text-gray-500 mt-0.5">{{ __('messages.pref_goal_hint') }}</p>
                    </div>

                    {{-- Stepper Control --}}
                    <div class="inline-flex items-center gap-3 bg-gray-50 p-1.5 rounded-xl border border-gray-200 self-start sm:self-center">
                        <button type="button" @click="targetCount = Math.max(1, targetCount - 1)"
                            class="w-8 h-8 rounded-lg bg-white text-gray-700 border border-gray-200 font-bold flex items-center justify-center hover:bg-gray-100 min-h-[32px]">-</button>
                        <input type="number" name="target_baca_bulanan" x-model="targetCount" min="1" max="50"
                            class="w-14 text-center font-bold text-sm bg-transparent outline-none">
                        <button type="button" @click="targetCount = Math.min(50, targetCount + 1)"
                            class="w-8 h-8 rounded-lg bg-white text-gray-700 border border-gray-200 font-bold flex items-center justify-center hover:bg-gray-100 min-h-[32px]">+</button>
                        <span class="text-xs font-semibold text-gray-600 pr-2">{{ __('messages.pref_books_per_month') }}</span>
                    </div>
                </div>

                {{-- Current Progress Gauge --}}
                <div class="mt-4 pt-2">
                    <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                        <span class="text-gray-600">{{ __('messages.pref_current_progress') }}</span>
                        <span class="text-emerald-800 font-bold">
                            {{ $bukuDibacaBulanIni }} dari <span x-text="targetCount"></span> buku selesai
                            (<span x-text="Math.min(100, Math.round(({{ $bukuDibacaBulanIni }} / Math.max(1, targetCount)) * 100)) + '%'"></span>)
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                        <div class="h-2.5 rounded-full bg-linear-to-r from-emerald-600 to-[#004236] transition-all duration-500"
                            :style="'width: ' + Math.min(100, Math.round(({{ $bukuDibacaBulanIni }} / Math.max(1, targetCount)) * 100)) + '%'"></div>
                    </div>
                </div>
            </div>

            {{-- Save Button for Preferences --}}
            <div class="flex justify-end pt-2">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#004236] px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-sm hover:bg-emerald-950 transition-all min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Preferensi Membaca</span>
                </button>
            </div>
        </div>

        {{-- ========================================================= --}}
        {{-- TAB 2: DATA DIRI & KEAMANAN AKUN --}}
        {{-- ========================================================= --}}
        <div x-show="activeTab === 'profil'" x-cloak class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-7 shadow-xs space-y-5">
            
            {{-- Member ID Badge (Read-Only) --}}
            <div class="p-4 rounded-xl bg-gray-50 border border-gray-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">{{ __('messages.id_card_number') }}</span>
                    <span class="text-sm sm:text-base font-mono font-bold text-[#004236]">{{ $user->nomor_anggota ?? 'ID-AG-' . str_pad($user->id_pengguna, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $user->isActive() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $user->isActive() ? __('messages.id_card_active') : __('messages.id_card_pending_status') }}
                    </span>
                </div>
            </div>

            {{-- Foto Profil --}}
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-2">
                    {{ __('messages.profile_avatar') }}
                </label>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-gray-100 border-2 border-gray-200 shrink-0 shadow-2xs">
                        <template x-if="previewUrl">
                            <img :src="previewUrl" alt="Foto Baru" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!previewUrl">
                            @if($user->foto_profil)
                                <img src="{{ asset('storage/foto_profil/' . $user->foto_profil) }}" alt="{{ $user->nama_pengguna }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-bold text-base text-gray-500 bg-gray-100">
                                    {{ strtoupper(substr($anggota?->nama_lengkap ?? $user->nama_pengguna, 0, 2)) }}
                                </div>
                            @endif
                        </template>
                    </div>

                    <div class="flex-1 min-w-0">
                        <input type="file" name="foto_profil" accept="image/*" @change="handleFileSelect($event)"
                            class="w-full text-xs text-gray-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004236] file:text-white hover:file:bg-emerald-950 file:cursor-pointer cursor-pointer border border-gray-200 rounded-xl p-1 bg-gray-50/60">
                        <p class="text-[11px] text-gray-500 mt-1">{{ __('messages.profile_avatar_hint') }}</p>
                    </div>
                </div>
            </div>

            {{-- Baris: Nama Lengkap & No Telp --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.full_name') }}</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $anggota?->nama_lengkap) }}" required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">
                    @error('nama_lengkap') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.phone_number') }}</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $anggota?->nomor_telepon) }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">
                    @error('nomor_telepon') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.address') }}</label>
                <textarea rows="2" name="alamat" required
                    class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">{{ old('alamat', $anggota?->alamat) }}</textarea>
                @error('alamat') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Baris: Email & Username --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-gray-100">
                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">
                    @error('email') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.username') }}</label>
                    <input type="text" name="nama_pengguna" value="{{ old('nama_pengguna', $user->nama_pengguna) }}" required
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">
                    @error('nama_pengguna') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Password Baru --}}
            <div class="pt-2 border-t border-gray-100">
                <label class="block text-xs sm:text-sm font-bold text-gray-800 mb-1.5">
                    {{ __('messages.password') }} <span class="text-xs font-normal text-gray-400">{{ __('messages.profile_new_password_hint') }}</span>
                </label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password"
                        placeholder="{{ __('messages.profile_new_password_placeholder') }}"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-3 pr-11 text-xs sm:text-sm outline-none transition focus:border-[#004236] focus:bg-white focus:ring-2 focus:ring-[#004236]/15">
                    <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 min-h-[32px] p-1 flex items-center justify-center">
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end pt-3">
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#004236] px-6 py-3 text-xs sm:text-sm font-bold text-white shadow-sm hover:bg-emerald-950 transition-all min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ __('messages.profile_save_changes') }}</span>
                </button>
            </div>
        </div>

        {{-- Modal Konfirmasi Simpan --}}
        <div x-show="showModal" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4" style="display: none;">
            <div @click.outside="showModal = false"
                class="w-full max-w-md rounded-2xl bg-white p-6 text-center shadow-2xl border border-gray-100">
                <div class="mx-auto w-12 h-12 rounded-full bg-emerald-100 text-[#004236] flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">{{ __('messages.profile_confirm_title') }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.profile_confirm_desc') }}</p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" @click="showModal = false"
                        class="flex-1 rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-100 min-h-[44px]">
                        {{ __('messages.profile_cancel') }}
                    </button>
                    <button type="button" @click="$el.closest('form').submit()"
                        class="flex-1 rounded-xl bg-[#004236] px-4 py-2.5 text-xs font-bold text-white hover:bg-emerald-950 min-h-[44px]">
                        {{ __('messages.profile_confirm_yes') }}
                    </button>
                </div>
            </div>
        </div>

    </form>

    {{-- ========================================================= --}}
    {{-- TAB 3: PENCAPAIAN, ANALITIK GENRE & BADGES --}}
    {{-- ========================================================= --}}
    <div x-show="activeTab === 'prestasi'" x-cloak class="space-y-6">
        
        {{-- Genre Distribution Card --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-xs">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ __('messages.genre_analytics_title') }}</h3>
                    <p class="text-xs text-gray-500">{{ __('messages.genre_analytics_desc') }}</p>
                </div>
            </div>

            @if(isset($genreStats) && $genreStats->isNotEmpty() && $totalGenreCount > 0)
                <div class="space-y-3 pt-2">
                    @foreach($genreStats as $stat)
                        @php
                            $persen = round(($stat->total / $totalGenreCount) * 100);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                <span class="text-gray-800">{{ $stat->nama_kategori }}</span>
                                <span class="text-gray-600 font-mono">{{ $stat->total }} buku ({{ $persen }}%)</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full bg-[#004236]" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400 py-4 text-center">{{ __('messages.genre_no_history') }}</p>
            @endif
        </div>

        {{-- Badges Grid --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-5 sm:p-6 shadow-xs">
            <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ __('messages.profile_badges_title') }}</h3>
                    <p class="text-xs text-gray-500">{{ __('messages.profile_badges_desc') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($badges ?? [] as $badge)
                    <div class="relative rounded-2xl border p-4 transition-all {{ $badge['tercapai'] ? 'border-emerald-200 bg-emerald-50/30 shadow-2xs' : 'border-gray-200 bg-gray-50/50 opacity-70' }}">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-2xs {{ $badge['tercapai'] ? 'bg-linear-to-br ' . $badge['bg_gradient'] . ' text-white' : 'bg-gray-200 text-gray-400' }}">
                                {!! $badge['icon'] !!}
                            </div>
                            @if($badge['tercapai'])
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    {{ __('messages.profile_unlocked') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200 text-gray-600">
                                    {{ __('messages.profile_locked') }}
                                </span>
                            @endif
                        </div>

                        <h4 class="text-xs sm:text-sm font-bold text-gray-900">{{ $badge['nama'] }}</h4>
                        <p class="text-[11px] text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $badge['deskripsi'] }}</p>

                        <div class="mt-3 pt-2.5 border-t border-gray-100">
                            <div class="flex items-center justify-between text-[10px] font-semibold text-gray-500 mb-1">
                                <span>{{ __('messages.profile_progress') }}</span>
                                <span class="font-bold text-gray-700">{{ $badge['progres'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full transition-all duration-500 {{ $badge['tercapai'] ? 'bg-emerald-500' : 'bg-gray-400' }}" style="width: {{ $badge['persen'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- TAB 4: KARTU ANGGOTA DIGITAL --}}
    {{-- ========================================================= --}}
    <div x-show="activeTab === 'kartu'" x-cloak class="space-y-6">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-xs flex flex-col items-center text-center">
            <div class="w-full max-w-lg mb-6">
                <x-id-card :user="$user" :anggota="$anggota" />
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full max-w-md pt-4 border-t border-gray-100">
                <a href="{{ route('anggota.kartu-anggota') }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-[#004236] px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-950 transition min-h-[44px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    <span>Buka Tampilan Penuh & Cetak</span>
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
