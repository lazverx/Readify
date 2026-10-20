@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-270">
        <div class="grid grid-cols-1 gap-9">
            {{-- ========================================================= --}}
            {{-- FEATURE 4: PRESTASI & LENCANA PEMBACA (GAMIFIKASI) --}}
            {{-- ========================================================= --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm dark:border-strokedark dark:bg-boxdark">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-5 border-b border-gray-100 dark:border-strokedark">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center text-2xl shrink-0">
                            🎖️
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">
                                Lencana & Prestasi Literasi
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Koleksi pencapaian membaca dan aktivitas perpustakaanmu
                            </p>
                        </div>
                    </div>

                    {{-- Quick Stats Pills --}}
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#0f4c3a]/10 text-[#0f4c3a]">
                            <span>🏆 Peringkat:</span>
                            <span class="text-sm font-extrabold">#{{ $userStats['rank'] ?? '-' }}</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                            <span>📚 {{ $userStats['total_pinjam'] ?? 0 }} Dipinjam</span>
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                            <span>⚡ {{ $userStats['pinjaman_tepat_waktu'] ?? 0 }} Tepat Waktu</span>
                        </span>
                    </div>
                </div>

                {{-- Badges Grid --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($badges ?? [] as $badge)
                        <div class="relative rounded-2xl border p-4 transition-all duration-300 {{ $badge['tercapai'] ? 'border-emerald-200 bg-linear-to-b from-emerald-50/50 to-white shadow-sm hover:shadow-md hover:-translate-y-0.5' : 'border-gray-200 bg-gray-50/60 opacity-70' }}">
                            
                            {{-- Header Badge --}}
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl shadow-xs {{ $badge['tercapai'] ? 'bg-linear-to-br ' . $badge['bg_gradient'] . ' text-white' : 'bg-gray-200 text-gray-400' }}">
                                    {{ $badge['icon'] }}
                                </div>
                                @if($badge['tercapai'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Terbuka
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-200 text-gray-600">
                                        🔒 Terkunci
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
                                    <span>Progres</span>
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

            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
                    <h3 class="font-medium text-black dark:text-white">
                        Profil Saya
                    </h3>
                </div>
                <form action="{{ route('anggota.profile.update') }}" method="POST" enctype="multipart/form-data" x-data="{ showModal: false }"
                    @submit.prevent="showModal = true">
                    @csrf
                    @method('PUT')
                    <div class="p-6.5">
                        <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    ID Anggota <span class="text-meta-1">*</span>
                                </label>
                                <input type="text" value="{{ $anggota->id_anggota }}" disabled
                                    class="w-full rounded border-[1.5px] border-stroke bg-gray py-3 px-5 font-medium text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary" />
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Nama Lengkap
                                </label>
                                <input type="text" name="nama_lengkap"
                                    value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_lengkap')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Foto Profil
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-stroke dark:border-strokedark">
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
                                <div class="flex-1">
                                    <input type="file" name="foto_profil" accept="image/*"
                                        class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                                    @error('foto_profil')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Alamat
                            </label>
                            <textarea rows="3" name="alamat"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">{{ old('alamat', $anggota->alamat) }}</textarea>
                            @error('alamat')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('email')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="w-full xl:w-1/2">
                                <label class="mb-2.5 block text-black dark:text-white">
                                    Username
                                </label>
                                <input type="text" name="nama_pengguna"
                                    value="{{ old('nama_pengguna', $user->nama_pengguna) }}"
                                    class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                                @error('nama_pengguna')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4.5">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Password <span class="text-meta-1 text-sm">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password" name="password" placeholder="Masukkan password baru"
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary" />
                            @error('password')
                                <span class="text-danger text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="flex w-full justify-center rounded-xl bg-[#004236] p-3 text-sm font-bold text-white transition-all hover:bg-[#00362b] shadow-lg hover:shadow-xl">
                            Simpan Perubahan
                        </button>
                    </div>

                    <!-- Modal Confirmation -->
                    <div x-show="showModal" x-transition.opacity
                        class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5"
                        style="display: none;">
                        <div @click.outside="showModal = false"
                            class="w-full max-w-125 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5">
                            <span class="mx-auto inline-block">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.1" width="60" height="60" rx="30" fill="#004236" />
                                    <path
                                        d="M30 20V30M30 40H30.01M30 10C18.9543 10 10 18.9543 10 30C10 41.0457 18.9543 50 30 50C41.0457 50 50 41.0457 50 30C50 18.9543 41.0457 10 30 10Z"
                                        stroke="#004236" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <h3 class="mt-5.5 pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">
                                Konfirmasi Perubahan
                            </h3>
                            <p class="mb-10 text-gray-500">
                                Apakah Anda yakin ingin menyimpan perubahan pada profil Anda?
                            </p>
                            <div class="flex flex-wrap items-center justify-center gap-4">
                                <button @click="showModal = false" type="button"
                                    class="w-full rounded border border-stroke bg-gray p-3 font-medium text-black transition hover:border-meta-1 hover:bg-meta-1 hover:text-white dark:border-strokedark dark:bg-meta-4 dark:text-white dark:hover:border-meta-1 dark:hover:bg-meta-1 sm:w-auto px-6">
                                    Batal
                                </button>
                                <button @click="$el.closest('form').submit()" type="button"
                                    class="w-full rounded bg-[#004236] p-3 font-medium text-white transition hover:bg-opacity-90 sm:w-auto px-6">
                                    Ya, Simpan
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
            class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4 py-5">
            <div @click.outside="showSuccess = false"
                class="w-full max-w-125 rounded-lg bg-white py-12 px-8 text-center dark:bg-boxdark md:py-15 md:px-17.5">
                <div
                    class="mx-auto mb-6 inline-flex h-20 w-20 items-center justify-center rounded-full bg-success/10 text-success">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">
                    Berhasil!
                </h3>
                <p class="mb-10 text-gray-500">
                    {{ session('success') }}
                </p>
                <button @click="showSuccess = false"
                    class="w-full rounded bg-success p-3 font-medium text-white transition hover:bg-opacity-90 sm:w-auto px-10">
                    Tutup
                </button>
            </div>
        </div>
    @endif
@endsection