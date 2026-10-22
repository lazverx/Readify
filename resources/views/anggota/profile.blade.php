@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-270">
        <div class="grid grid-cols-1 gap-6 sm:gap-9">
            {{-- Prestasi & Lencana Pembaca --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-4 sm:p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-gray-100 dark:border-strokedark">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">
                                {{ __('messages.profile_badges_title') }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('messages.profile_badges_desc') }}
                            </p>
                        </div>
                    </div>

                    {{-- Quick Stats Pills --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#0f4c3a]/10 text-[#0f4c3a]">
                            <svg class="w-3.5 h-3.5 text-[#0f4c3a]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ __('messages.profile_rank') }}:</span>
                            <span class="text-sm font-extrabold">#{{ $userStats['rank'] ?? '-' }}</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                            <svg class="w-3.5 h-3.5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>{{ $userStats['total_pinjam'] ?? 0 }} {{ __('messages.profile_borrowed') }}</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                            <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $userStats['pinjaman_tepat_waktu'] ?? 0 }} {{ __('messages.profile_on_time') }}</span>
                        </span>
                    </div>
                </div>

                {{-- Badges Grid --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($badges ?? [] as $badge)
                        <div class="relative rounded-2xl border p-4 transition-all duration-300 {{ $badge['tercapai'] ? 'border-emerald-200 bg-linear-to-b from-emerald-50/50 to-white shadow-sm hover:shadow-md hover:-translate-y-0.5' : 'border-gray-200 bg-gray-50/60 opacity-70' }}">
                            
                            {{-- Header Badge --}}
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-xs {{ $badge['tercapai'] ? 'bg-linear-to-br ' . $badge['bg_gradient'] . ' text-white' : 'bg-gray-200 text-gray-400' }}">
                                    {!! $badge['icon'] !!}
                                </div>
                                @if($badge['tercapai'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('messages.profile_unlocked') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200 text-gray-600">
                                        <svg class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        {{ __('messages.profile_locked') }}
                                    </span>
                                @endif
                            </div>

                            {{-- Badge Info --}}
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white leading-snug">
                                {{ $badge['nama'] }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                {{ $badge['deskripsi'] }}
                            </p>

                            {{-- Progress Bar --}}
                            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-strokedark">
                                <div class="flex items-center justify-between text-[11px] font-medium text-gray-500 mb-1">
                                    <span>{{ __('messages.profile_progress') }}</span>
                                    <span class="font-bold text-gray-700 dark:text-gray-300">{{ $badge['progres'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full transition-all duration-500 {{ $badge['tercapai'] ? 'bg-emerald-500' : 'bg-gray-400' }}"
                                        style="width: {{ $badge['persen'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm dark:border-strokedark dark:bg-boxdark overflow-hidden">
                <div class="border-b border-gray-100 py-4 px-4 sm:px-6.5 dark:border-strokedark">
                    <h3 class="font-bold text-gray-900 dark:text-white">
                        {{ __('messages.profile_my_profile') }}
                    </h3>
                </div>
                <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data" x-data="{ showModal: false }"
                    @submit.prevent="showModal = true">
                    @csrf
                    @method('PUT')
                    <div class="p-4 sm:p-6.5 space-y-4 sm:space-y-4.5">
                        <div class="flex flex-col gap-4 sm:gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                    {{ __('messages.profile_member_id') }} <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" value="{{ $anggota->id_anggota }}" disabled
                                    class="w-full rounded-xl border-[1.5px] border-stroke bg-gray py-3 px-4 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                    {{ __('messages.full_name') }}
                                </label>
                                <input type="text" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                                    class="w-full rounded-xl border-[1.5px] border-stroke bg-transparent py-3 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_lengkap')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                {{ __('messages.profile_avatar') }}
                            </label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-stroke dark:border-strokedark shrink-0">
                                    @if($user->foto_profil)
                                        <img src="{{ asset('storage/foto_profil/' . $user->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <input type="file" name="foto_profil" accept="image/*"
                                        class="w-full text-xs sm:text-sm rounded-xl border-[1.5px] border-stroke bg-transparent py-2.5 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    <p class="text-xs text-gray-500 mt-1">{{ __('messages.profile_avatar_hint') }}</p>
                                    @error('foto_profil')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                {{ __('messages.address') }}
                            </label>
                            <textarea rows="3" name="alamat"
                                class="w-full rounded-xl border-[1.5px] border-stroke bg-transparent py-3 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('alamat', $anggota->alamat) }}</textarea>
                            @error('alamat')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-4 sm:gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                    {{ __('messages.email') }}
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded-xl border-[1.5px] border-stroke bg-transparent py-3 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                    {{ __('messages.username') }}
                                </label>
                                <input type="text" name="nama_pengguna"
                                    value="{{ old('nama_pengguna', $user->nama_pengguna) }}"
                                    class="w-full rounded-xl border-[1.5px] border-stroke bg-transparent py-3 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_pengguna')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-2.5 block text-xs sm:text-sm font-medium text-black dark:text-white">
                                {{ __('messages.password') }} <span class="text-gray-400 text-xs">{{ __('messages.profile_new_password_hint') }}</span>
                            </label>
                            <input type="password" name="password" placeholder="{{ __('messages.profile_new_password_placeholder') }}"
                                class="w-full rounded-xl border-[1.5px] border-stroke bg-transparent py-3 px-4 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            @error('password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="flex w-full justify-center items-center rounded-xl bg-[#004236] py-3.5 px-6 text-sm font-bold text-white transition-all hover:bg-[#00362b] shadow-md hover:shadow-lg active:scale-[0.99] min-h-[48px]">
                                {{ __('messages.profile_save_changes') }}
                            </button>
                        </div>
                    </div>

                    <!-- Modal Confirmation -->
                    <div x-show="showModal" x-transition.opacity
                        class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
                        style="display: none;">
                        <div @click.outside="showModal = false"
                            class="w-full max-w-lg rounded-2xl bg-white p-6 sm:p-8 text-center dark:bg-boxdark shadow-2xl">
                            <span class="mx-auto inline-flex items-center justify-center w-14 h-14 rounded-full bg-emerald-50 text-[#004236]">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </span>
                            <h3 class="mt-4 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                                {{ __('messages.profile_confirm_title') }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.profile_confirm_desc') }}
                            </p>
                            <div class="mt-6 flex flex-col-reverse sm:flex-row items-center justify-center gap-3">
                                <button @click="showModal = false" type="button"
                                    class="w-full sm:w-auto rounded-xl border border-gray-200 bg-gray-50 px-6 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 min-h-[44px]">
                                    {{ __('messages.profile_cancel') }}
                                </button>
                                <button @click="$el.closest('form').submit()" type="button"
                                    class="w-full sm:w-auto rounded-xl bg-[#004236] px-6 py-2.5 text-sm font-bold text-white transition hover:bg-[#00362b] min-h-[44px]">
                                    {{ __('messages.profile_confirm_yes') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    @if (session('success'))
        <div x-data="{ showSuccess: true }" x-show="showSuccess" x-init="setTimeout(() => showSuccess = false, 3000)"
            x-transition.opacity
            class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div @click.outside="showSuccess = false"
                class="w-full max-w-sm rounded-2xl bg-white p-6 sm:p-8 text-center dark:bg-boxdark shadow-2xl">
                <div class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    {{ __('messages.profile_success') }}
                </h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    {{ session('success') }}
                </p>
                <div class="mt-6">
                    <button @click="showSuccess = false"
                        class="w-full rounded-xl bg-emerald-600 py-2.5 px-6 text-sm font-bold text-white transition hover:bg-emerald-700 min-h-[44px]">
                        {{ __('messages.profile_close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
@endsection