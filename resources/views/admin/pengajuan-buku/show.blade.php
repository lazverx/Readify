@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        {{-- Breadcrumb --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('admin.pengajuan-buku.index') }}" class="hover:text-[#004236] transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Daftar Pengajuan Buku
            </a>
            <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-800 font-semibold truncate max-w-xs">{{ $pengajuan->judul_buku }}</span>
        </nav>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-green-50 border border-green-200 p-4 shadow-sm">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">
                    <svg class="h-4 w-4 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-green-900">Berhasil!</h4>
                    <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 p-4 shadow-sm">
                <h4 class="text-sm font-bold text-red-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Mohon periksa data yang Anda masukkan:
                </h4>
                <ul class="list-disc list-inside space-y-1 text-xs text-red-700 ml-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Status Header Banner --}}
        @php
            $isMenunggu = $pengajuan->status === 'menunggu';
            $isDisetujui = $pengajuan->status === 'disetujui';
            $isDitolak = $pengajuan->status === 'ditolak';

            $bannerBg = $isMenunggu
                ? 'from-amber-500 to-orange-500'
                : ($isDisetujui ? 'from-[#004236] to-[#00705a]' : 'from-red-600 to-rose-700');
            $badgeText = $isMenunggu ? 'Menunggu Review' : ($isDisetujui ? 'Disetujui & Diterbitkan' : 'Pengajuan Ditolak');
        @endphp

        <div class="mb-6 rounded-2xl bg-linear-to-r {{ $bannerBg }} text-white p-6 shadow-md flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider backdrop-blur-xs">
                    {{ $badgeText }}
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold mt-2 leading-tight">{{ $pengajuan->judul_buku }}</h2>
                <p class="text-sm text-white/80 mt-1">Diusulkan oleh <span class="font-bold text-white">{{ $pengajuan->nama_pengusul }}</span> • {{ $pengajuan->dibuat_pada ? $pengajuan->dibuat_pada->diffForHumans() : '' }}</p>
            </div>
            @if($isDisetujui && $pengajuan->buku)
                <a href="{{ route('admin.buku.show', $pengajuan->buku->id_buku) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-[#004236] hover:bg-gray-100 transition-all shadow-md shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Lihat Buku di Katalog
                </a>
            @endif
        </div>

        {{-- Main Layout --}}
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

            {{-- Kolom Kiri (Ringkasan Pengajuan Anggota) --}}
            <div class="xl:col-span-4 flex flex-col gap-6">

                {{-- Card Info Asli Pengajuan --}}
                <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-700">Detail Usulan Anggota</h3>
                        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-medium">Data Awal</span>
                    </div>

                    <div class="divide-y divide-gray-100 text-sm">
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-400 block mb-0.5">Judul Buku</span>
                            <span class="font-bold text-gray-900">{{ $pengajuan->judul_buku }}</span>
                        </div>
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-400 block mb-0.5">Penulis / Pengarang</span>
                            <span class="font-medium text-gray-800">{{ $pengajuan->nama_penulis }}</span>
                        </div>
                        <div class="grid grid-cols-2 px-6 py-3.5 gap-2">
                            <div>
                                <span class="text-xs font-semibold uppercase text-gray-500 block mb-0.5">Nomor ISBN</span>
                                <span class="font-medium text-gray-800">{{ $pengajuan->isbn ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-xs font-semibold uppercase text-gray-500 block mb-0.5">Tahun Terbit</span>
                                <span class="font-medium text-gray-800">{{ $pengajuan->tahun_terbit ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-500 block mb-0.5">Penerbit</span>
                            <span class="font-medium text-gray-800">{{ $pengajuan->penerbit ?? '-' }}</span>
                        </div>
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-400 block mb-0.5">Kategori Diusulkan</span>
                            @if($pengajuan->kategori)
                                <span class="inline-flex items-center rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 border border-blue-100">
                                    {{ $pengajuan->kategori }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Tidak dicantumkan</span>
                            @endif
                        </div>
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-400 block mb-0.5">Pengusul</span>
                            <span class="font-semibold text-gray-900">{{ $pengajuan->nama_pengusul }}</span>
                            @if($pengajuan->pengguna)
                                <p class="text-xs text-gray-500 mt-0.5">{{ $pengajuan->pengguna->email }} ({{ ucfirst($pengajuan->pengguna->level_akses) }})</p>
                            @endif
                        </div>
                        <div class="px-6 py-3.5">
                            <span class="text-xs font-semibold uppercase text-gray-400 block mb-1">Alasan Pengusulan</span>
                            <div class="rounded-xl bg-gray-50 p-3 border border-gray-100 text-xs text-gray-700 leading-relaxed">
                                {{ $pengajuan->alasan_pengusulan }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Admin Sebelumnya (jika sudah ada) --}}
                @if($pengajuan->catatan_admin)
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-blue-800 mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Catatan Admin
                        </h4>
                        <p class="text-sm text-blue-900 leading-relaxed">{{ $pengajuan->catatan_admin }}</p>
                    </div>
                @endif

                {{-- Buku yang Sudah Diterbitkan (jika disetujui) --}}
                @if($isDisetujui && $pengajuan->buku)
                    <div class="rounded-2xl border border-green-200 bg-white p-5 shadow-sm overflow-hidden">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-100 text-green-700">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <h4 class="text-sm font-bold text-gray-900">Buku Resmi di Katalog</h4>
                        </div>
                        <div class="flex gap-4 items-center">
                            @if($pengajuan->buku->sampul)
                                <img src="{{ Storage::url($pengajuan->buku->sampul) }}" alt="Cover" class="h-28 w-20 rounded-lg object-cover shadow-md border border-gray-100 shrink-0">
                            @else
                                <div class="h-28 w-20 rounded-lg bg-gray-100 border flex items-center justify-center text-xs text-gray-400 shrink-0">No Cover</div>
                            @endif
                            <div class="text-xs space-y-1">
                                <p class="font-bold text-gray-900 text-sm line-clamp-2">{{ $pengajuan->buku->judul_buku }}</p>
                                <p class="text-gray-600">Rak: <span class="font-semibold text-gray-800">{{ $pengajuan->buku->lokasi_rak }}</span></p>
                                <p class="text-gray-600">Stok: <span class="font-semibold text-green-700">{{ $pengajuan->buku->stok }} eks</span></p>
                                <p class="text-gray-600">Halaman: <span class="font-semibold text-gray-800">{{ $pengajuan->buku->jumlah_halaman ?? '-' }}</span></p>
                                <a href="{{ route('admin.buku.show', $pengajuan->buku->id_buku) }}" class="inline-block mt-2 text-xs font-bold text-[#004236] hover:underline">
                                    Kelola Buku Ini
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Kolom Kanan: FORM ACC (LENGKAPI DATA & COVER) ATAU FORM TOLAK --}}
            <div class="xl:col-span-8">

                @if($isMenunggu)
                    {{-- Alpine Component untuk Tab Keputusan (ACC vs Tolak) --}}
                    <div x-data="{ decision: 'acc' }" class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">

                        {{-- Header Tabs Pilihan Keputusan --}}
                        <div class="border-b border-gray-100 bg-gray-50/70 p-2 flex items-center gap-2">
                            <button type="button" @click="decision = 'acc'"
                                :class="decision === 'acc' ? 'bg-[#004236] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
                                class="flex-1 py-3 px-4 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                ACC & Terbitkan Buku ke Katalog
                            </button>
                            <button type="button" @click="decision = 'tolak'"
                                :class="decision === 'tolak' ? 'bg-red-600 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'"
                                class="py-3 px-6 rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tolak Pengajuan
                            </button>
                        </div>

                        {{-- PANEL 1: FORM ACC & TERBITKAN KE KATALOG --}}
                        <div x-show="decision === 'acc'" class="p-6 md:p-8">
                            <div class="mb-6 bg-emerald-50 border border-emerald-200 rounded-xl p-4 flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-emerald-900">ACC & Lengkapi Data Katalog</h4>
                                    <p class="text-xs text-emerald-700 mt-0.5">
                                        Data dari pengusul telah terisi otomatis di bawah. Anda tinggal <strong>mengunggah foto cover (sampul)</strong>, menentukan <strong>stok awal</strong>, serta melengkapi informasi lokasi rak & halaman buku.
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.pengajuan-buku.acc', $pengajuan->id_pengajuan) }}" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                {{-- Judul & Penulis --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Judul Buku <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="judul_buku" value="{{ old('judul_buku', $pengajuan->judul_buku) }}" required
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Nama Penulis / Pengarang <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="penulis" value="{{ old('penulis', $pengajuan->nama_penulis) }}" required
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                    </div>
                                </div>

                                {{-- ISBN, Penerbit, Tahun --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Nomor ISBN
                                        </label>
                                        <input type="text" name="isbn" value="{{ old('isbn', $pengajuan->isbn) }}" placeholder="978-xxx-xxx"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Penerbit
                                        </label>
                                        <input type="text" name="penerbit" value="{{ old('penerbit', $pengajuan->penerbit) }}" placeholder="Nama Penerbit"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                            Tahun Terbit
                                        </label>
                                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $pengajuan->tahun_terbit ?? date('Y')) }}" min="1900" max="{{ date('Y') }}"
                                            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                    </div>
                                </div>

                                {{-- Stok, Halaman, Bahasa, Lokasi Rak (DATA KURANG YANG DILENGKAPI ADMIN) --}}
                                <div class="bg-gray-50/70 border border-gray-200/80 rounded-2xl p-5 space-y-4">
                                    <h5 class="text-xs font-extrabold uppercase tracking-wider text-gray-600 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        Data Kelengkapan Inventaris Perpustakaan
                                    </h5>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                                Stok Buku Awal <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="stok" value="{{ old('stok', 5) }}" min="0" required
                                                class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm font-bold text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20">
                                            <span class="text-[10px] text-gray-400">Jumlah fisik yang ada</span>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                                Jumlah Halaman
                                            </label>
                                            <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman', 250) }}" min="1" max="10000"
                                                class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20">
                                            <span class="text-[10px] text-gray-400">Total lembar halaman</span>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                                Bahasa Buku
                                            </label>
                                            <select name="bahasa"
                                                class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20">
                                                <option value="id" {{ old('bahasa') == 'id' ? 'selected' : '' }}>Indonesia</option>
                                                <option value="en" {{ old('bahasa') == 'en' ? 'selected' : '' }}>English</option>
                                                <option value="ja" {{ old('bahasa') == 'ja' ? 'selected' : '' }}>Japanese</option>
                                                <option value="ar" {{ old('bahasa') == 'ar' ? 'selected' : '' }}>Arabic</option>
                                                <option value="ko" {{ old('bahasa') == 'ko' ? 'selected' : '' }}>Korean</option>
                                            </select>
                                            <span class="text-[10px] text-gray-400">Bahasa isi buku</span>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">
                                                Lokasi Rak
                                            </label>
                                            <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak', 'Rak B-01') }}" placeholder="Contoh: Rak B-01"
                                                class="w-full rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20">
                                            <span class="text-[10px] text-gray-400">Lokasi fisik di perpus</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kategori Multi-select --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">
                                        Pilih Kategori Katalog (Bisa Lebih Dari Satu)
                                    </label>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2.5">
                                        @foreach($kategoriList as $kat)
                                            @php
                                                $isChecked = old('kategori')
                                                    ? in_array($kat->id_kategori, (array)old('kategori'))
                                                    : ($pengajuan->kategori && stripos($pengajuan->kategori, $kat->nama_kategori) !== false);
                                            @endphp
                                            <label class="flex items-center gap-2 p-2.5 rounded-xl border border-gray-200 hover:border-[#004236] cursor-pointer transition-colors has-checked:bg-emerald-50 has-checked:border-[#004236]">
                                                <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" {{ $isChecked ? 'checked' : '' }}
                                                    class="rounded text-[#004236] focus:ring-[#004236]">
                                                <span class="text-xs font-semibold text-gray-800">{{ $kat->nama_kategori }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Upload Cover / Sampul Buku (DENGAN PREVIEW INTERAKTIF) --}}
                                <div x-data="{ previewUrl: null }">
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Foto Sampul Buku (Cover Image)
                                    </label>
                                    <div class="flex flex-col sm:flex-row items-center gap-5 p-4 rounded-2xl border-2 border-dashed border-gray-300 hover:border-[#004236] bg-gray-50/50 transition-colors">
                                        {{-- Image Preview Area --}}
                                        <div class="shrink-0">
                                            <template x-if="previewUrl">
                                                <img :src="previewUrl" alt="Cover Preview" class="h-32 w-24 object-cover rounded-xl shadow-md border border-gray-200">
                                            </template>
                                            <template x-if="!previewUrl">
                                                <div class="h-32 w-24 rounded-xl bg-gray-200 border border-gray-300 flex flex-col items-center justify-center text-center p-2 text-gray-400">
                                                    <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-[10px]">Preview Cover</span>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex-1 space-y-2">
                                            <input type="file" name="sampul" id="sampulInput" accept="image/jpeg,image/png,image/jpg,image/webp"
                                                @change="previewUrl = URL.createObjectURL($event.target.files[0])"
                                                class="block w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#004236] file:text-white hover:file:bg-[#00362b] cursor-pointer">
                                            <p class="text-[11px] text-gray-500">
                                                Format: JPG, PNG, WebP (maks. 2MB). Jika tidak diunggah, sistem otomatis memakai cover placeholder default.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sinopsis Buku --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Sinopsis / Deskripsi Buku
                                    </label>
                                    <textarea name="sinopsis" rows="4" placeholder="Tuliskan sinopsis buku..."
                                        class="w-full rounded-xl border border-gray-200 p-4 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all resize-none">{{ old('sinopsis', $pengajuan->alasan_pengusulan) }}</textarea>
                                </div>

                                {{-- Catatan Balasan ke Pengusul --}}
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Pesan Notifikasi untuk Pengusul <span class="text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <input type="text" name="catatan_admin" value="{{ old('catatan_admin', 'Usulan buku Anda telah disetujui dan telah resmi tersedia di katalog perpustakaan!') }}"
                                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-gray-900 outline-none focus:border-[#004236] focus:ring-2 focus:ring-[#004236]/20 transition-all">
                                </div>

                                {{-- Submit ACC Button --}}
                                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <a href="{{ route('admin.pengajuan-buku.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800">
                                        Batal & Kembali
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-8 py-3 text-sm font-extrabold text-white hover:bg-[#00362b] transition-all shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        ACC & Terbitkan ke Katalog Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- PANEL 2: FORM TOLAK PENGAJUAN --}}
                        <div x-show="decision === 'tolak'" class="p-6 md:p-8" style="display: none;">
                            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-700">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-red-900">Konfirmasi Penolakan Pengajuan</h4>
                                    <p class="text-xs text-red-700 mt-0.5">
                                        Pengajuan ini tidak akan diterbitkan ke katalog. Anggota pengusul akan menerima notifikasi otomatis beserta catatan alasan penolakan yang Anda tulis di bawah.
                                    </p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('admin.pengajuan-buku.status', $pengajuan->id_pengajuan) }}" class="space-y-6">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                        Alasan Penolakan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="catatan_admin" rows="5" required
                                        placeholder="Tuliskan alasan mengapa buku ini belum dapat diadakan (misal: Buku serupa sudah tersedia, stok distributor kosong, dll)..."
                                        class="w-full rounded-xl border border-gray-200 p-4 text-sm text-gray-900 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all resize-none">{{ old('catatan_admin') }}</textarea>
                                </div>

                                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                    <button type="button" @click="decision = 'acc'" class="text-sm font-semibold text-gray-500 hover:text-gray-800">
                                        Kembali ke Opsi ACC
                                    </button>
                                    <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-6 py-2.5 text-sm font-extrabold text-white hover:bg-red-700 transition-all shadow-md">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Konfirmasi Tolak Pengajuan
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @else
                    {{-- Status Sudah Selesai Diproses (Disetujui / Ditolak) --}}
                    <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm">
                        @if($isDisetujui)
                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-100 text-green-600">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-extrabold text-gray-900">Pengajuan Telah Disetujui</h3>
                            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                                Buku ini telah resmi dibuat dan diterbitkan ke dalam katalog buku perpustakaan Readify.
                            </p>
                            @if($pengajuan->buku)
                                <div class="mt-6 flex flex-wrap justify-center gap-3">
                                    <a href="{{ route('admin.buku.show', $pengajuan->buku->id_buku) }}"
                                        class="inline-flex items-center gap-2 rounded-xl bg-[#004236] px-6 py-2.5 text-sm font-bold text-white hover:bg-[#00362b] transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Lihat Buku di Katalog
                                    </a>
                                    <a href="{{ route('admin.pengajuan-buku.index') }}"
                                        class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                        Kembali ke Daftar Pengajuan
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-red-100 text-red-600">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-extrabold text-gray-900">Pengajuan Telah Ditolak</h3>
                            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">
                                Keputusan penolakan telah dikirimkan ke anggota pengusul melalui notifikasi akun.
                            </p>
                            <div class="mt-6 flex justify-center gap-3">
                                <a href="{{ route('admin.pengajuan-buku.index') }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                                    Kembali ke Daftar Pengajuan
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

            </div>

        </div>

    </div>
@endsection