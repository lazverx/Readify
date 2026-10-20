@forelse($buku as $item)
    <a href="{{ route('anggota.buku.detail', $item->id_buku) }}"
        class="group flex flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden cursor-pointer relative"
        title="Lihat detail: {{ $item->judul_buku }}">

        {{-- Image & Badges --}}
        <div class="relative aspect-2/3 w-full overflow-hidden bg-gray-100">
            @if($item->sampul)
                <img src="{{ Storage::url($item->sampul) }}" alt="{{ $item->judul_buku }}" loading="lazy"
                    class="h-full w-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="flex h-full w-full items-center justify-center bg-linear-to-br from-[#e8f4f0] to-[#c8e6d8]">
                    <svg class="h-16 w-16 text-[#0f4c3a] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25">
                        </path>
                    </svg>
                </div>
            @endif

            {{-- Status Stok Badge --}}
            <div class="absolute top-2 left-2 z-10">
                @if($item->stok > 0)
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-emerald-600/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        Tersedia ({{ $item->stok }})
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1 rounded-full bg-rose-600/90 px-2 py-0.5 text-[10px] font-bold uppercase text-white backdrop-blur-sm shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        Habis
                    </span>
                @endif
            </div>

            {{-- Quick Preview Icon Button --}}
            <button type="button"
                onclick="event.preventDefault(); event.stopPropagation(); window.openQuickPreview({{ $item->id_buku }});"
                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/90 text-gray-700 hover:text-[#0f4c3a] hover:bg-white shadow flex items-center justify-center transition-all transform hover:scale-110 z-10"
                title="Lihat Pratinjau Cepat">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>

            {{-- Hover overlay --}}
            <div
                class="absolute inset-0 bg-[#0f4c3a]/25 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center p-2">
                <div class="flex flex-col items-center gap-1.5 transform group-hover:scale-100 scale-90 transition-all duration-200">
                    <span class="rounded-full bg-white/95 px-3 py-1 text-xs font-bold text-[#0f4c3a] shadow-md backdrop-blur-sm">
                        Lihat Detail →
                    </span>
                    <button type="button"
                        onclick="event.preventDefault(); event.stopPropagation(); window.openQuickPreview({{ $item->id_buku }});"
                        class="rounded-full bg-[#0f4c3a] px-2.5 py-1 text-[11px] font-semibold text-white shadow-md hover:bg-emerald-900 transition-colors">
                        👁️ Pratinjau
                    </button>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex flex-col flex-1 p-3">
            <div class="flex items-center justify-between mb-1">
                <span class="text-[10px] font-semibold tracking-wider text-[#0f4c3a] uppercase">
                    {{ $item->kategori->first()?->nama_kategori ?? 'Umum' }}
                </span>
                @if($item->rak)
                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 font-medium">
                        {{ $item->rak }}
                    </span>
                @endif
            </div>
            <h4 class="text-sm font-bold text-gray-900 line-clamp-2 leading-snug mb-1" title="{{ $item->judul_buku }}">
                {{ $item->judul_buku }}
            </h4>
            <p class="text-xs text-gray-500 line-clamp-1 mt-auto">{{ $item->penulis }}</p>
        </div>
    </a>
@empty
    <div class="col-span-full py-16 text-center">
        <div class="flex flex-col items-center justify-center gap-3">
            <div class="rounded-full bg-gray-100 p-5">
                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Buku tidak ditemukan</h3>
                <p class="mt-0.5 text-xs text-gray-500">Coba gunakan kata kunci lain atau sesuaikan filter pencarian.</p>
            </div>
            <button type="button" onclick="window.resetKatalogFilter()" class="mt-1 text-xs font-semibold text-[#0f4c3a] hover:underline">
                Reset Semua Filter
            </button>
        </div>
    </div>
@endforelse