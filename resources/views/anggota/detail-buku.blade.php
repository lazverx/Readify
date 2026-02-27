@extends('layouts.app')

@section('content')
    {{-- Breadcrumb --}}
    <nav class="mb-4 flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('anggota.dashboard') }}" class="hover:text-[#0f4c3a] transition-colors flex items-center gap-1">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Katalog Buku
        </a>
        <span>/</span>
        <span class="text-gray-800 font-medium line-clamp-1">{{ $buku->judul_buku }}</span>
    </nav>

    {{-- Main Card: 2 kolom, muat di layar tanpa scroll --}}
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden"
        style="height: calc(100vh - 160px); min-height: 520px;">
        <div class="flex h-full">

            {{-- ===== KOLOM KIRI: Cover + Tombol Pinjam ===== --}}
            <div
                class="w-64 xl:w-72 flex-shrink-0 flex flex-col bg-gradient-to-b from-[#e8f4f0] to-[#d0ebe0] border-r border-gray-100">

                {{-- Cover --}}
                <div class="flex-1 flex items-center justify-center p-5 overflow-hidden">
                    @if($buku->sampul)
                        <img src="{{ Storage::url($buku->sampul) }}" alt="{{ $buku->judul_buku }}"
                            class="max-h-full w-full object-contain rounded-xl shadow-lg"
                            style="max-height: calc(100vh - 340px);">
                    @else
                        <div class="w-full rounded-xl shadow-lg bg-white/50 flex items-center justify-center"
                            style="aspect-ratio: 2/3; max-height: calc(100vh - 340px);">
                            <svg class="h-20 w-20 text-[#0f4c3a] opacity-30" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Status + Tombol (bagian bawah kolom kiri, tetap) --}}
                <div class="px-5 pb-5 space-y-3 shrink-0">
                    {{-- Status Stok --}}
                    <div class="text-center">
                        @if($buku->stok > 0)
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700">
                                <span class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                                Tersedia &bull; {{ $buku->stok }} stok
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Stok Habis
                            </span>
                        @endif
                    </div>

                    {{-- Tombol Aksi --}}
                    {{-- Wishlist Button --}}
                    @php
                        $inWishlist = \App\Models\KoleksiPribadi::where('id_pengguna', auth()->user()->id_pengguna)->where('id_buku', $buku->id_buku)->exists();
                    @endphp
                    <div x-data="{
                            inWishlist: {{ $inWishlist ? 'true' : 'false' }},
                            loading: false,
                            toggleWishlist() {
                                if (this.loading) return;
                                this.loading = true;

                                const isAdding = !this.inWishlist;
                                const url = isAdding 
                                    ? '{{ route('anggota.koleksi.store', $buku->id_buku) }}' 
                                    : '{{ route('anggota.koleksi.destroy', $buku->id_buku) }}';

                                const method = isAdding ? 'POST' : 'DELETE';

                                fetch(url, {
                                    method: method,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        this.inWishlist = !this.inWishlist;
                                        // Optional: show toast notification here
                                    }
                                })
                                .catch(error => console.error('Error:', error))
                                .finally(() => {
                                    this.loading = false;
                                });
                            }
                        }">
                        <button @click="toggleWishlist" :disabled="loading"
                            :class="inWishlist ? 'border-red-500 bg-red-50 text-red-600 hover:bg-red-100' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'"
                            class="w-full flex items-center justify-center gap-2 rounded-xl border py-2.5 text-sm font-semibold transition shadow-sm mb-3">

                            <template x-if="loading">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                            </template>

                            <template x-if="!loading && inWishlist">
                                <span class="flex items-center gap-2">
                                    <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>
                                    Hapus dari Koleksi
                                </span>
                            </template>

                            <template x-if="!loading && !inWishlist">
                                <span class="flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Tambah ke Koleksi
                                </span>
                            </template>
                        </button>
                    </div>

                    @if(!$akunTerverifikasi)
                        {{-- Akun belum diverifikasi --}}
                        <div class="rounded-xl border-2 border-amber-300 bg-amber-50 p-4 text-center">
                            <div class="mb-2 flex items-center justify-center">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100">
                                    <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xs font-bold text-amber-800 leading-snug mb-1">
                                @if(auth()->user()->status === 'pending')
                                    Akun Menunggu Verifikasi
                                @else
                                    Akun Tidak Aktif
                                @endif
                            </p>
                            <p class="text-[11px] text-amber-700 leading-snug mb-3">
                                @if(auth()->user()->status === 'pending')
                                    Akun Anda sedang diproses admin. Anda hanya dapat melihat katalog.
                                @else
                                    Akun Anda ditolak. Hubungi petugas untuk info lebih lanjut.
                                @endif
                            </p>
                            <a href="{{ route('anggota.profile') }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-amber-600 px-3 py-1.5 text-[11px] font-bold text-white hover:bg-amber-700 transition">
                                Lihat Status Akun →
                            </a>
                        </div>
                        <button disabled
                            class="w-full rounded-xl bg-gray-200 py-3 text-sm font-bold text-gray-400 cursor-not-allowed mt-2">
                            Peminjaman Tidak Tersedia
                        </button>
                    @elseif($sedangMeminjam)

                        <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-3">
                            <p class="text-xs font-medium text-yellow-800 text-center">
                                Sedang dipinjam.
                                <a href="{{ route('anggota.pinjaman') }}"
                                    class="underline block mt-1 hover:text-yellow-900">Lihat pinjaman saya →</a>
                            </p>
                        </div>
                    @elseif($buku->stok > 0)
                        <div x-data="{ durasi: 7, showConfirm: false }">
                            {{-- Slider durasi ringkas --}}
                            <div class="mb-2">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs text-gray-500">Durasi: <strong class="text-[#0f4c3a]"
                                            x-text="durasi"></strong> hari</span>
                                    <span class="text-xs text-gray-400">Maks. 14 hari</span>
                                </div>
                                <input type="range" min="1" max="14" x-model="durasi"
                                    class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer accent-[#0f4c3a]">
                                <div class="flex justify-between mt-0.5">
                                    <span class="text-[10px] text-gray-400">1</span>
                                    <span class="text-[10px] text-gray-400">14 hari</span>
                                </div>
                            </div>

                            {{-- Info jatuh tempo mini --}}
                            <div class="mb-3 rounded-lg bg-white/70 border border-[#c8e6d8] p-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Pinjam:</span>
                                    <span
                                        class="font-semibold text-black">{{ \Carbon\Carbon::today()->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <div class="flex justify-between mt-0.5">
                                    <span class="text-gray-500">Jatuh tempo:</span>
                                    <span class="font-semibold text-[#0f4c3a]" id="jatuh-tempo-label">-</span>
                                </div>
                            </div>

                            {{-- Tombol Pinjam --}}
                            <button @click="showConfirm = true"
                                class="w-full rounded-xl bg-[#0f4c3a] py-3 text-sm font-bold text-white transition hover:bg-[#0a382b] flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Pinjam Buku Sekarang
                            </button>

                            {{-- Confirm Modal --}}
                            <div x-show="showConfirm" x-transition
                                class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                                style="display: none;">
                                <div @click.outside="showConfirm = false"
                                    class="w-full max-w-md rounded-2xl bg-white p-8 shadow-2xl">
                                    <div class="mb-6 text-center">
                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#e8f4f0]">
                                            <svg class="h-8 w-8 text-[#0f4c3a]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-black mb-1">Konfirmasi Peminjaman</h3>
                                        <p class="text-gray-500 text-sm">Pastikan data peminjaman sudah benar</p>
                                    </div>

                                    <div class="mb-6 rounded-xl bg-gray-50 p-4 space-y-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <span class="text-sm text-gray-500 shrink-0">Buku:</span>
                                            <span
                                                class="text-sm font-semibold text-black text-right">{{ $buku->judul_buku }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">Durasi:</span>
                                            <span class="text-sm font-semibold text-[#0f4c3a]" x-text="durasi + ' hari'"></span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-500">Jatuh Tempo:</span>
                                            <span class="text-sm font-semibold text-[#0f4c3a]" id="confirm-jatuh-tempo">-</span>
                                        </div>
                                    </div>

                                    <form action="{{ route('anggota.booking.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                                        <input type="hidden" name="durasi_pinjam" :value="durasi">
                                        <div class="flex gap-3">
                                            <button type="button" @click="showConfirm = false"
                                                class="flex-1 rounded-xl border border-gray-300 py-3 font-medium text-gray-700 hover:bg-gray-50 transition">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="flex-1 rounded-xl bg-[#0f4c3a] py-3 font-bold text-white hover:bg-[#0a382b] transition shadow-md">
                                                Ya, Pinjam!
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('alpine:init', () => {
                                const today = new Date();
                                const updateLabel = (durasi) => {
                                    const jatuhTempo = new Date(today);
                                    jatuhTempo.setDate(today.getDate() + parseInt(durasi));
                                    const formatted = jatuhTempo.toLocaleDateString('id-ID', {
                                        day: 'numeric', month: 'short', year: 'numeric'
                                    });
                                    const el = document.getElementById('jatuh-tempo-label');
                                    const el2 = document.getElementById('confirm-jatuh-tempo');
                                    if (el) el.textContent = formatted;
                                    if (el2) el2.textContent = formatted;
                                };
                                updateLabel(7);
                                document.querySelector('input[type=range]')?.addEventListener('input', (e) => {
                                    updateLabel(e.target.value);
                                });
                            });
                        </script>
                    @else
                        <button disabled
                            class="w-full rounded-xl bg-gray-200 py-3 text-sm font-bold text-gray-400 cursor-not-allowed">
                            Stok Habis - Tidak Tersedia
                        </button>
                    @endif
                </div>
            </div>

            {{-- ===== KOLOM KANAN: Info Buku + Sinopsis (scroll mandiri) ===== --}}
            <div class="flex-1 overflow-y-auto">
                <div class="p-6 xl:p-8">

                    {{-- Kategori badges --}}
                    <div class="mb-3 flex flex-wrap gap-2">
                        @forelse($buku->kategori as $kat)
                            <a href="{{ route('anggota.dashboard', ['kategori' => $kat->nama_kategori]) }}"
                                class="inline-flex items-center rounded-full bg-[#e8f4f0] px-3 py-1 text-xs font-bold text-[#0f4c3a] hover:bg-[#0f4c3a] hover:text-white transition-colors">
                                {{ $kat->nama_kategori }}
                            </a>
                        @empty
                            <span
                                class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">Umum</span>
                        @endforelse
                    </div>

                    {{-- Judul & Penulis --}}
                    <h1 class="mb-1 text-2xl xl:text-3xl font-bold text-black leading-tight">{{ $buku->judul_buku }}</h1>
                    <p class="mb-5 text-base text-[#0f4c3a] font-medium">{{ $buku->penulis }}</p>

                    {{-- Info Grid --}}
                    <div class="mb-5 grid grid-cols-2 xl:grid-cols-3 gap-3 rounded-xl bg-gray-50 p-4">
                        @if($buku->isbn)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">ISBN</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->isbn }}</span>
                            </div>
                        @endif
                        @if($buku->penerbit)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Penerbit</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->penerbit }}</span>
                            </div>
                        @endif
                        @if($buku->tahun_terbit)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Tahun
                                    Terbit</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->tahun_terbit }}</span>
                            </div>
                        @endif
                        @if($buku->jumlah_halaman)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Jumlah
                                    Halaman</span>
                                <span
                                    class="text-sm font-semibold text-black">{{ number_format($buku->jumlah_halaman, 0, ',', '.') }}
                                    hal.</span>
                            </div>
                        @endif
                        @if($buku->bahasa)
                            <div>
                                <span
                                    class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Bahasa</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->formatted_bahasa }}</span>
                            </div>
                        @endif
                        @if($buku->lokasi_rak)
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase tracking-wide font-medium mb-0.5">Lokasi
                                    Rak</span>
                                <span class="text-sm font-semibold text-black">{{ $buku->lokasi_rak }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Sinopsis --}}
                    @if($buku->sinopsis)
                        <div>
                            <h2
                                class="mb-2 text-sm font-bold text-gray-500 flex items-center gap-2 uppercase tracking-wide text-gray-500">
                                <svg class="h-4 w-4 text-[#0f4c3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Sinopsis
                            </h2>
                            <div
                                class="prose prose-sm max-w-none text-gray-600 leading-relaxed
                                                                                                [&_p]:mb-3 [&_strong]:font-semibold [&_em]:italic
                                                                                                [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5">
                                {!! $buku->sinopsis !!}
                            </div>
                        </div>
                    @endif

                    {{-- ========== ULASAN (REVIEWS) SECTION ========== --}}
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="mb-4 text-lg font-bold text-black flex items-center gap-2">
                            <svg class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            Ulasan Pembaca
                        </h2>

                        {{-- Rating Summary --}}
                        <div class="mb-6 rounded-xl bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 p-4">
                            <div class="flex items-center gap-6">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-amber-600">{{ number_format($ratingRataRata, 1) }}</div>
                                    <div class="flex justify-center gap-0.5 my-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-4 w-4 {{ $i <= round($ratingRataRata) ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $jumlahUlasan }} ulasan</div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Tambah Ulasan --}}
                        @auth
                            @if($akunTerverifikasi)
                                @if($sudahMeminjam && !$sudahMengulas)
                                    {{-- Boleh kasih ulasan --}}
                                    <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4">
                                        <h3 class="text-sm font-bold text-gray-700 mb-3">Tulis Ulasan Anda</h3>
                                        <form action="{{ route('anggota.ulasan.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                                            
                                            {{-- Rating Stars --}}
                                            <div class="mb-3">
                                                <label class="block text-xs font-medium text-gray-600 mb-2">Rating</label>
                                                <div class="flex gap-2" x-data="{ rating: 0 }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <button type="button" 
                                                            @click="rating = {{ $i }}"
                                                            @mouseenter="rating = {{ $i }}"
                                                            class="transition-transform hover:scale-110">
                                                            <svg class="h-8 w-8 transition-colors" 
                                                                :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-300'"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                            </svg>
                                                        </button>
                                                    @endfor
                                                    <input type="hidden" name="rating" x-model="rating">
                                                </div>
                                                @error('rating')
                                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            {{-- Isi Ulasan --}}
                                            <div class="mb-3">
                                                <label class="block text-xs font-medium text-gray-600 mb-2">Komentar (opsional)</label>
                                                <textarea name="isi_ulasan" rows="3" 
                                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#0f4c3a] focus:ring-1 focus:ring-[#0f4c3a]"
                                                    placeholder="Tulis pendapat Anda tentang buku ini..."></textarea>
                                            </div>

                                            <button type="submit" 
                                                class="w-full rounded-xl bg-[#0f4c3a] py-2.5 text-sm font-bold text-white hover:bg-[#0a382b] transition">
                                                Kirim Ulasan
                                            </button>
                                        </form>
                                    </div>
                                @elseif($sudahMengulas)
                                    {{-- Sudah pernah mengulas --}}
                                    <div class="mb-6 rounded-xl bg-green-50 border border-green-200 p-4">
                                        <div class="flex items-center gap-2 text-green-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="text-sm font-medium">Anda sudah pernah mengulas buku ini</span>
                                        </div>
                                    </div>
                                @elseif(!$sudahMeminjam)
                                    {{-- Belum pernah pinjam --}}
                                    <div class="mb-6 rounded-xl bg-blue-50 border border-blue-200 p-4">
                                        <div class="flex items-center gap-2 text-blue-700">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm font-medium">Pinjam buku ini terlebih dahulu untuk memberikan ulasan</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endauth

                        {{-- Daftar Ulasan --}}
                        @if($ulasan->count() > 0)
                            <div class="space-y-4">
                                @foreach($ulasan as $item)
                                    <div class="rounded-xl border border-gray-200 bg-white p-4">
                                        <div class="flex items-start gap-3">
                                            {{-- Avatar --}}
                                            <div class="h-10 w-10 rounded-full bg-[#0f4c3a] flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                {{ strtoupper(substr($item->anggota->nama_lengkap ?? 'A', 0, 2)) }}
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between gap-2 mb-1">
                                                    <h4 class="text-sm font-bold text-gray-800">{{ $item->anggota->nama_lengkap ?? 'Anggota' }}</h4>
                                                    <span class="text-xs text-gray-400">{{ $item->dibuat_pada->locale('id')->diffForHumans() }}</span>
                                                </div>
                                                
                                                {{-- Rating Stars --}}
                                                <div class="flex gap-0.5 mb-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="h-4 w-4 {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                
                                                {{-- Isi Ulasan --}}
                                                @if($item->isi_ulasan)
                                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item->isi_ulasan }}</p>
                                                @endif

                                                {{-- Delete Button (hanya untuk pemilik ulasan) --}}
                                                @auth
                                                    @if($item->id_pengguna === auth()->user()->id_pengguna)
                                                        <form action="{{ route('anggota.ulasan.destroy', $item->id_ulasan) }}" method="POST" class="mt-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?')">
                                                                Hapus ulasan
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <p class="text-sm">Belum ada ulasan untuk buku ini.</p>
                                <p class="text-xs text-gray-400">Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Buku Terkait --}}
    @if(isset($bukuTerkat) && $bukuTerkat->count() > 0)
        <div class="mt-8">
            <h2 class="mb-4 text-lg font-bold text-black">Buku Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($bukuTerkat as $related)
                    <a href="{{ route('anggota.buku.detail', $related->id_buku) }}"
                        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
                        <div class="aspect-2/3 w-full overflow-hidden bg-gray-100">
                            @if($related->sampul)
                                <img src="{{ Storage::url($related->sampul) }}" alt="{{ $related->judul_buku }}" loading="lazy"
                                    class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="h-full w-full flex items-center justify-center bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8]">
                                    <svg class="h-10 w-10 text-[#0f4c3a] opacity-30" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <p class="text-xs text-[#0f4c3a] font-medium mb-0.5">
                                {{ $related->kategori->first()?->nama_kategori ?? 'Umum' }}
                            </p>
                            <h4 class="text-sm font-bold text-black line-clamp-2 leading-snug">{{ $related->judul_buku }}</h4>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $related->penulis }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection
