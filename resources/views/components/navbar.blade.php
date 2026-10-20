<div class="sticky top-0 z-50 w-full bg-white shadow-md">
    <nav class="container mx-auto px-6 py-4" x-data="{ isOpen: false }">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/Logo.svg') }}" alt="Readify Logo" class="h-8 w-auto">
                </a>
            </div>

            <!-- Menu Items (Desktop) -->
            <div class="hidden items-center gap-8 md:flex">
                <a href="#beranda"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_home') }}</a>
                <a href="#fitur"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_features') }}</a>
                <a href="#cara-pinjam"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_how_it_works') }}</a>
                <a href="#katalog"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_catalog') }}</a>
                <a href="#layanan"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_services') }}</a>
                <a href="#tentang-kami"
                    class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_about') }}</a>
            </div>

            <!-- Desktop Auth/CTA & Language Switch -->
            <div class="hidden items-center gap-3 md:flex">
                <!-- Language Switcher ID / EN -->
                <div class="flex items-center rounded-full bg-gray-100 p-0.5 text-xs font-bold border border-gray-200" aria-label="{{ __('messages.language') }}">
                    <a href="{{ route('lang.switch', 'id') }}"
                       class="px-2.5 py-1 rounded-full transition-colors {{ app()->getLocale() === 'id' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                        ID
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-2.5 py-1 rounded-full transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                        EN
                    </a>
                </div>

                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : (auth()->user()->isPetugas() ? route('petugas.dashboard') : route('anggota.dashboard')) }}"
                        class="text-sm font-bold text-[#004236] hover:text-[#00362b] transition-colors">
                        {{ __('messages.nav_dashboard') }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="rounded-full border border-red-200 bg-white px-5 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50 focus:ring-2 focus:ring-red-300">
                            {{ __('messages.nav_logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-full border border-gray-200 bg-white px-5 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:ring-2 focus:ring-[#004236]">
                        {{ __('messages.nav_login') }}
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button (Mobile) -->
            <button @click="isOpen = !isOpen" class="flex md:hidden text-gray-700 p-2 rounded-lg focus:ring-2 focus:ring-[#004236]" aria-label="Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="isOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="absolute left-0 right-0 top-full z-50 flex w-full flex-col gap-4 border-t border-gray-100 bg-white p-4 shadow-lg md:hidden">
            <a href="#beranda"
                class="nav-link text-sm font-medium text-gray-900 hover:text-[#004236] transition-colors">{{ __('messages.nav_home') }}</a>
            <a href="#fitur"
                class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_features') }}</a>
            <a href="#cara-pinjam"
                class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_how_it_works') }}</a>
            <a href="#katalog"
                class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_catalog') }}</a>
            <a href="#layanan"
                class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_services') }}</a>
            <a href="#tentang-kami"
                class="nav-link text-sm font-medium text-gray-600 hover:text-[#004236] transition-colors">{{ __('messages.nav_about') }}</a>

            <!-- Mobile Language Switcher -->
            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                <span class="text-xs font-semibold text-gray-500">{{ __('messages.language') }}:</span>
                <div class="flex items-center rounded-full bg-gray-100 p-0.5 text-xs font-bold border border-gray-200">
                    <a href="{{ route('lang.switch', 'id') }}"
                       class="px-3 py-1 rounded-full transition-colors {{ app()->getLocale() === 'id' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600' }}">
                        Indonesia
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-3 py-1 rounded-full transition-colors {{ app()->getLocale() === 'en' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600' }}">
                        English
                    </a>
                </div>
            </div>

            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : (auth()->user()->isPetugas() ? route('petugas.dashboard') : route('anggota.dashboard')) }}"
                    class="nav-link text-sm font-bold text-[#004236] transition-colors">{{ __('messages.nav_dashboard') }}</a>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full text-center rounded-full border border-red-200 bg-white px-6 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                        {{ __('messages.nav_logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="w-full text-center rounded-full border border-gray-200 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    {{ __('messages.nav_login') }}
                </a>
            @endauth
        </div>
    </nav>
</div>