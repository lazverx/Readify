@auth
    @php
        $user = Auth::user();
        $isAnggota = $user->isAnggota();
        $isPetugas = $user->isPetugas();
        $isAdmin = $user->isAdmin();
        $currentRoute = Route::currentRouteName();
    @endphp

    <nav aria-label="Mobile Navigation"
        class="fixed bottom-0 left-0 right-0 z-40 flex items-center justify-around border-t border-gray-200/90 bg-white/95 px-2 py-1.5 shadow-[0_-4px_20px_rgba(0,0,0,0.06)] backdrop-blur-md xl:hidden">
        
        @if($isAnggota)
            {{-- 1. Katalog --}}
            @php $activeKatalog = in_array($currentRoute, ['anggota.dashboard', 'anggota.buku.detail']); @endphp
            <a href="{{ route('anggota.dashboard') }}"
                class="flex min-w-[56px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all active:scale-95 {{ $activeKatalog ? 'text-[#004236] font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="h-5 w-5 {{ $activeKatalog ? 'stroke-[2.2]' : 'stroke-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span class="text-[10px] tracking-tight leading-none">{{ __('messages.bottom_nav_catalog') }}</span>
                @if($activeKatalog)
                    <span class="h-1 w-1 rounded-full bg-[#004236] mt-0.5"></span>
                @endif
            </a>

            {{-- 2. Pinjaman --}}
            @php $activePinjaman = $currentRoute === 'anggota.pinjaman'; @endphp
            <a href="{{ route('anggota.pinjaman') }}"
                class="flex min-w-[56px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all active:scale-95 {{ $activePinjaman ? 'text-[#004236] font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="h-5 w-5 {{ $activePinjaman ? 'stroke-[2.2]' : 'stroke-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </div>
                <span class="text-[10px] tracking-tight leading-none">{{ __('messages.bottom_nav_loans') }}</span>
                @if($activePinjaman)
                    <span class="h-1 w-1 rounded-full bg-[#004236] mt-0.5"></span>
                @endif
            </a>

            {{-- 3. Komunitas --}}
            @php $activeKomunitas = $currentRoute === 'komunitas.index'; @endphp
            <a href="{{ route('komunitas.index') }}"
                class="flex min-w-[56px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all active:scale-95 {{ $activeKomunitas ? 'text-[#004236] font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="h-5 w-5 {{ $activeKomunitas ? 'stroke-[2.2]' : 'stroke-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-[10px] tracking-tight leading-none">{{ __('messages.bottom_nav_community') }}</span>
                @if($activeKomunitas)
                    <span class="h-1 w-1 rounded-full bg-[#004236] mt-0.5"></span>
                @endif
            </a>

            {{-- 4. Riwayat & Denda --}}
            @php $activeRiwayat = $currentRoute === 'anggota.riwayat'; @endphp
            <a href="{{ route('anggota.riwayat') }}"
                class="flex min-w-[56px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all active:scale-95 {{ $activeRiwayat ? 'text-[#004236] font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="h-5 w-5 {{ $activeRiwayat ? 'stroke-[2.2]' : 'stroke-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] tracking-tight leading-none">{{ __('messages.bottom_nav_history') }}</span>
                @if($activeRiwayat)
                    <span class="h-1 w-1 rounded-full bg-[#004236] mt-0.5"></span>
                @endif
            </a>

            {{-- 5. Profil --}}
            @php $activeProfil = $currentRoute === 'anggota.profile'; @endphp
            <a href="{{ route('anggota.profile') }}"
                class="flex min-w-[56px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all active:scale-95 {{ $activeProfil ? 'text-[#004236] font-bold' : 'text-gray-500 hover:text-gray-800' }}">
                <div class="relative">
                    <svg class="h-5 w-5 {{ $activeProfil ? 'stroke-[2.2]' : 'stroke-1.5' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="text-[10px] tracking-tight leading-none">{{ __('messages.bottom_nav_profile') }}</span>
                @if($activeProfil)
                    <span class="h-1 w-1 rounded-full bg-[#004236] mt-0.5"></span>
                @endif
            </a>

        @elseif($isPetugas)
            {{-- Petugas Mobile Nav --}}
            <a href="{{ route('petugas.dashboard') }}"
                class="flex min-w-[64px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ $currentRoute === 'petugas.dashboard' ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_circulation') }}</span>
            </a>
            <a href="{{ route('petugas.booking.index') }}"
                class="flex min-w-[64px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ $currentRoute === 'petugas.booking.index' ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_booking_process') }}</span>
            </a>
            <a href="{{ route('petugas.pengembalian.index') }}"
                class="flex min-w-[64px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ $currentRoute === 'petugas.pengembalian.index' ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_return_book') }}</span>
            </a>
            <a href="{{ route('petugas.katalog') }}"
                class="flex min-w-[64px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ $currentRoute === 'petugas.katalog' ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_catalog') }}</span>
            </a>

        @elseif($isAdmin)
            {{-- Admin Mobile Nav --}}
            <a href="{{ route('dashboard') }}"
                class="flex min-w-[60px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ $currentRoute === 'dashboard' ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                <span class="text-[10px] leading-none">Dashboard</span>
            </a>
            <a href="{{ route('admin.buku.index') }}"
                class="flex min-w-[60px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ str_contains($currentRoute, 'admin.buku') ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_books') }}</span>
            </a>
            <a href="{{ route('admin.peminjaman.index') }}"
                class="flex min-w-[60px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ str_contains($currentRoute, 'admin.peminjaman') ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_loans') }}</span>
            </a>
            <a href="{{ route('admin.pengajuan-buku.index') }}"
                class="flex min-w-[60px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ str_contains($currentRoute, 'admin.pengajuan-buku') ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_book_proposals') }}</span>
            </a>
            <a href="{{ route('admin.verifikasi-anggota.index') }}"
                class="flex min-w-[60px] min-h-[44px] flex-col items-center justify-center gap-0.5 rounded-xl px-2 py-1 transition-all {{ str_contains($currentRoute, 'admin.verifikasi-anggota') ? 'text-[#004236] font-bold' : 'text-gray-500' }}">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                <span class="text-[10px] leading-none">{{ __('messages.menu_verify_members') }}</span>
            </a>
        @endif

    </nav>
@endauth
