<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Readify - Sistem Perpustakaan Digital</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        html {
            scroll-behavior: smooth;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .delay-100 {
            transition-delay: 0.1s;
        }

        .delay-200 {
            transition-delay: 0.2s;
        }

        .delay-300 {
            transition-delay: 0.3s;
        }

        .delay-400 {
            transition-delay: 0.4s;
        }

        .delay-500 {
            transition-delay: 0.5s;
        }
    </style>
</head>

<body class="font-sans antialiased text-[#3F3D56] bg-[#E6E6E6]">
    <x-navbar />
    <x-hero />

    <!-- Seksi Fitur (Smart Dashboard) -->
    <section id="fitur" class="py-16 md:py-24 bg-white relative overflow-hidden">
        <div class="container mx-auto px-6">
            <!-- Top Header (Badge & Tagline) -->
            <!-- Top Header (Badge & Tagline) -->
            <div
                class="reveal-on-scroll flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div class="px-8 py-2 rounded-full bg-[#084734] text-white font-medium text-sm">
                    {{ __('messages.features_badge') }}
                </div>
                <p class="text-[#3F3D56] font-semibold text-sm md:text-base">
                    {{ __('messages.features_tagline') }}
                </p>
            </div>

            <!-- Headline & Description -->
            <div class="reveal-on-scroll delay-100 max-w-4xl mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight mb-6 text-[#3F3D56]">
                    {{ __('messages.features_headline_1') }} <span class="text-[#87D800]">{{ __('messages.features_headline_2') }}</span> {{ __('messages.features_headline_3') }}
                </h2>
                <p class="text-gray-600 text-base md:text-xl leading-relaxed">
                    {{ __('messages.features_description') }}
                </p>
            </div>

            <!-- Content Grid (Cards Left, Image Right) -->
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left: 2x2 Grid Cards -->
                <div class="w-full lg:w-1/2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card 1 -->
                    <div
                        class="reveal-on-scroll delay-200 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#084734] mb-3">{{ __('messages.feat_booking_title') }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ __('messages.feat_booking_desc') }}
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] rounded-full mt-4"></div>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="reveal-on-scroll delay-300 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#3F3D56] mb-3">{{ __('messages.feat_card_title') }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ __('messages.feat_card_desc') }}
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="reveal-on-scroll delay-400 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#3F3D56] mb-3">{{ __('messages.feat_fine_title') }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ __('messages.feat_fine_desc') }}
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>

                    <!-- Card 4 -->
                    <div
                        class="reveal-on-scroll delay-500 bg-white p-6 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-[#87D800] transition group min-h-[220px] flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#87D800] mb-3">{{ __('messages.feat_dashboard_title') }}</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ __('messages.feat_dashboard_desc') }}
                            </p>
                        </div>
                        <div class="w-full h-0.5 bg-[#87D800] mt-4"></div>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="w-full lg:w-1/2 flex justify-center lg:justify-end">
                    <img src="{{ asset('img/fitur-vector.svg') }}" alt="Ilustrasi Fitur"
                        class="reveal-on-scroll delay-300 w-full max-w-lg object-contain">
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Cara Kerja (3 Step) -->
    <section id="cara-pinjam" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="reveal-on-scroll text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-[#084734] mb-3">{{ __('messages.how_title') }}</h2>
                <p class="text-lg md:text-xl text-[#3F3D56] font-medium">{{ __('messages.how_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Step 1: Full Width -->
                <div
                    class="reveal-on-scroll delay-100 md:col-span-2 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-12 group hover:shadow-lg transition-all duration-300">
                    <div class="md:w-1/2 flex flex-col items-start text-left">
                        <span
                            class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                            {{ __('messages.step_1_badge') }}
                        </span>
                        <h3 class="text-2xl md:text-3xl font-bold text-[#084734] mb-4">{{ __('messages.step_1_title') }}</h3>
                        <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                            {{ __('messages.step_1_desc') }}
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center md:justify-end">
                        <img src="{{ asset('img/cara-pinjam-1.svg') }}" alt="Registrasi"
                            class="h-[250px] w-auto object-contain">
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col items-start h-full group hover:shadow-lg transition-all duration-300">
                    <span
                        class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                        {{ __('messages.step_2_badge') }}
                    </span>
                    <h3 class="text-2xl font-bold text-[#084734] mb-4">{{ __('messages.step_2_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        {{ __('messages.step_2_desc') }}
                    </p>
                    <div class="w-full flex justify-center mt-auto">
                        <img src="{{ asset('img/cara-pinjam-2.svg') }}" alt="Booking"
                            class="h-[220px] w-auto object-contain">
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="reveal-on-scroll delay-300 bg-[#F9FCF8] border border-[#E4F5E0] rounded-[2.5rem] p-8 md:p-12 flex flex-col items-start h-full group hover:shadow-lg transition-all duration-300">
                    <span
                        class="inline-block px-6 py-2 rounded-full border border-gray-300 text-gray-500 text-sm font-medium mb-6 bg-white group-hover:border-[#87D800] group-hover:text-[#084734] transition-colors">
                        {{ __('messages.step_3_badge') }}
                    </span>
                    <h3 class="text-2xl font-bold text-[#084734] mb-4">{{ __('messages.step_3_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        {{ __('messages.step_3_desc') }}
                    </p>
                    <div class="w-full flex justify-center mt-auto">
                        <img src="{{ asset('img/cara-pinjam-3.svg') }}" alt="Pick Up"
                            class="h-[220px] w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Eksplorasi & Katalog -->
    <section id="katalog" class="py-16 md:py-24 bg-[#084734] text-white overflow-hidden relative">
        <!-- Background Elements -->
        <div
            class="absolute -top-20 -right-20 w-96 h-96 bg-[#87D800] rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>
        <div
            class="absolute -bottom-20 -left-20 w-96 h-96 bg-[#CEF17B] rounded-full mix-blend-multiply filter blur-3xl opacity-20">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <!-- Header & Search -->
            <div class="reveal-on-scroll text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">{{ __('messages.catalog_section_title') }}</h2>
                <p class="text-[#CEF17B]/80 text-base md:text-lg mb-10">{{ __('messages.catalog_section_subtitle') }}</p>

                <!-- Search component (Responsive on Mobile) -->
                <form action="{{ auth()->check() ? route('anggota.dashboard') : route('login') }}" method="GET" class="bg-white p-2 rounded-full shadow-2xl flex items-center max-w-2xl mx-auto">
                    <!-- Category Indicator (hidden on small mobile screens to keep input spacious) -->
                    <div class="relative group hidden sm:block">
                        <a href="#katalog"
                            class="flex items-center gap-2 px-6 py-3 text-gray-700 font-medium hover:bg-gray-50 rounded-full transition-colors">
                            <span>{{ __('messages.bottom_nav_catalog') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>

                    <div class="h-8 w-px bg-gray-200 mx-2 hidden sm:block"></div>

                    <!-- Search Input -->
                    <div class="flex-1 flex items-center px-3 sm:px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2 sm:mr-3 shrink-0" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" placeholder="{{ __('messages.hero_search_placeholder') }}"
                            class="w-full py-2 text-sm text-gray-700 focus:outline-none placeholder-gray-400 bg-transparent">
                    </div>

                    <button type="submit"
                        class="px-5 sm:px-6 py-2.5 sm:py-3 bg-[#004236] text-white text-xs font-bold rounded-full hover:bg-[#00362b] transition shadow-md shrink-0">
                        {{ __('messages.action_search') }}
                    </button>
                </form>
            </div>

            <!-- Featured Cards (3 Columns) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
                <!-- Card 1: Baru Di Tambahkan -->
                <div
                    class="reveal-on-scroll delay-100 bg-[#CEF17B] rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-[#084734] mb-1 leading-tight">{{ __('messages.card_new_arrivals') }}</h3>
                        <a href="{{ auth()->check() ? route('anggota.dashboard') : route('login') }}"
                            class="mt-6 px-5 py-2.5 bg-[#8FA75B] text-white text-xs font-bold rounded-lg hover:bg-[#7d924d] transition shadow-lg inline-block">
                            {{ __('messages.action_borrow') }}
                        </a>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku1.png') }}" alt="Buku Baru"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 rotate-3 group-hover:rotate-0">
                    </div>
                </div>

                <!-- Card 2: Sedang Populer -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#87D800] rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-[#084734] mb-1 leading-tight">{{ __('messages.card_trending') }}</h3>
                        <a href="{{ auth()->check() ? route('anggota.dashboard') : route('login') }}"
                            class="mt-6 px-5 py-2.5 bg-[#4F7F00] text-white text-xs font-bold rounded-lg hover:bg-[#3d6300] transition shadow-lg inline-block">
                            {{ __('messages.action_borrow') }}
                        </a>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku3.jpg') }}" alt="Buku Populer"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 -rotate-3 group-hover:rotate-0">
                    </div>
                </div>

                <!-- Card 3: Rekomendasi -->
                <div
                    class="reveal-on-scroll delay-300 bg-brand-600 rounded-3xl p-6 relative overflow-hidden h-64 md:h-72 flex items-center group border border-[#87D800]/20">
                    <div class="relative z-10 w-1/2 flex flex-col items-start justify-center h-full">
                        <h3 class="text-2xl font-bold text-white mb-1 leading-tight">{{ __('messages.card_recommended') }}</h3>
                        <a href="{{ auth()->check() ? route('anggota.dashboard') : route('login') }}"
                            class="mt-6 px-5 py-2.5 bg-[#CEF17B] text-[#084734] text-xs font-bold rounded-lg hover:bg-[#b8d96b] transition shadow-lg inline-block">
                            {{ __('messages.action_borrow') }}
                        </a>
                    </div>
                    <div class="absolute right-4 top-4 bottom-4 w-1/2 flex items-center justify-center">
                        <img src="{{ asset('img/buku2.webp') }}" alt="Buku Rekomendasi"
                            class="h-full object-cover rounded-md shadow-2xl transform group-hover:scale-105 transition-transform duration-500 rotate-6 group-hover:rotate-0">
                    </div>
                </div>
            </div>

            <!-- Bottom Banner -->
            <div
                class="reveal-on-scroll delay-400 bg-[#FAFFF3] border border-[#ECEDF0] rounded-[2.5rem] p-8 md:p-12 flex flex-col md:flex-row items-center gap-12 text-[#084734]">
                <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                    <img src="{{ asset('img/katalog-buku-1.svg') }}" alt="Illustration"
                        class="h-48 md:h-64 object-contain">
                </div>
                <div class="w-full md:w-2/3 text-center">
                    <p class="text-gray-600 font-medium mb-4">{{ __('messages.welcome_cta_desc') }}</p>
                    <h2 class="text-2xl md:text-4xl font-bold mb-8 leading-tight">
                        {{ __('messages.welcome_cta_title') }}
                    </h2>
                    <div class="flex justify-center">
                        <a href="{{ auth()->check() ? route('anggota.dashboard') : route('register') }}"
                            class="bg-[#084734] text-white px-8 py-3 rounded-lg font-bold hover:bg-brand-600 transition shadow-lg inline-block">
                            {{ __('messages.welcome_cta_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Layanan Kami -->
    <section id="layanan" class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <!-- Header -->
            <div class="reveal-on-scroll flex flex-col md:flex-row justify-between items-start mb-16 gap-4">
                <h2 class="text-3xl md:text-5xl font-bold text-[#084734]">{{ __('messages.services_title') }}</h2>
                <p class="text-xl text-[#3F3D56] font-medium">{{ __('messages.services_subtitle') }}</p>
            </div>

            <!-- Layanan Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Request Buku -->
                <div
                    class="reveal-on-scroll delay-100 bg-white border-2 border-[#87D800] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full group hover:shadow-xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-[#3F3D56] mb-2">{{ __('messages.service_1_title') }}</h3>
                    <div class="w-16 h-1 bg-[#87D800] rounded-full mb-6"></div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-auto">
                        {{ __('messages.service_1_desc') }}
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-1.svg') }}" alt="Request Buku"
                            class="h-40 w-auto object-contain">
                    </div>
                </div>

                <!-- Card 2: Loket Cepat -->
                <div
                    class="reveal-on-scroll delay-200 bg-[#084734] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <h3 class="text-2xl font-bold text-white mb-2">{{ __('messages.service_2_title') }}</h3>
                    <div class="w-16 h-1 bg-white/20 rounded-full mb-6"></div>
                    <p class="text-white/80 text-sm leading-relaxed mb-auto">
                        {{ __('messages.service_2_desc') }}
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-2.svg') }}" alt="Loket Cepat"
                            class="h-40 w-auto object-contain brightness-0 invert">
                    </div>
                </div>

                <!-- Card 3: Komunitas -->
                <div
                    class="reveal-on-scroll delay-300 bg-white border-2 border-[#87D800] rounded-[2.5rem] p-8 flex flex-col items-center text-center h-full group hover:shadow-xl transition-all duration-300">
                    <h3 class="text-2xl font-bold text-[#3F3D56] mb-2">{{ __('messages.service_3_title') }}</h3>
                    <div class="w-16 h-1 bg-[#87D800] rounded-full mb-6"></div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-auto">
                        {{ __('messages.service_3_desc') }}
                    </p>
                    <div class="mt-8 h-48 w-full flex items-end justify-center">
                        <img src="{{ asset('img/layanan-3.svg') }}" alt="Komunitas" class="h-40 w-auto object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seksi Tentang Kami & Tim -->
    <section id="tentang-kami" class="py-16 md:py-24 bg-white overflow-hidden">
        <div class="container mx-auto px-6">
            <!-- Bagian 1: Tentang Kami -->
            <div class="reveal-on-scroll flex flex-col md:flex-row items-center gap-12 mb-32">
                <!-- Text Content -->
                <div class="w-full md:w-1/2">
                    <h2 class="text-3xl md:text-5xl font-bold text-[#084734] mb-6">
                        Tentang <span class="text-[#87D800]">Kami</span>
                    </h2>
                    <h3 class="text-xl md:text-2xl font-bold text-[#3F3D56] mb-4">
                        Modernisasi Literasi untuk Masa Depan.
                    </h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Mengubah perpustakaan konvensional jadi <span
                            class="text-[#87D800] font-bold">ekosistem digital yang match</span> sama kebutuhan zaman
                        sekarang.
                        Lewat inovasi teknologi, kami membuat akses informasi jadi lebih mudah, cepat, dan terpercaya buat
                        semua orang.
                    </p>
                </div>
                <!-- Illustration -->
                <div class="w-full md:w-1/2 flex justify-center md:justify-end relative">
                    <!-- Decorative background element -->
                    <div class="absolute -bottom-4 right-10 w-3/4 h-4 bg-gray-100 rounded-full blur-sm"></div>
                    <img src="{{ asset('img/tentang-kami.svg') }}" alt="Tentang Kami Library"
                        class="max-w-md w-full object-contain relative z-10">
                </div>
            </div>

            <!-- Bagian 2: Dev -->
            <div class="reveal-on-scroll delay-200 text-center mb-16 relative">
                <!-- Decorative Asterisk/Flower -->
                <div class="absolute left-[10%] -top-10 hidden md:block animate-spin-slow"
                    style="animation-duration: 10s;">
                    <img src="{{ asset('img/tim-bintang.svg') }}" alt="Star Decoration" class="w-20 h-20">
                </div>

                <h2 class="text-2xl md:text-4xl font-bold text-[#3F3D56]">
                    <span class="text-[#87D800]"></span> Orang dibalik pengembangan <span
                        class="bg-[#CEF17B] px-2 py-1 rotate-2 inline-block text-[#084734]">Readify.</span>
                </h2>
            </div>

            <!-- Team Cards Grid -->
            <div class="flex justify-center py-12">
                <!-- Card: Faiz Akhrian -->
                <div class="reveal-on-scroll delay-300 flex flex-col items-center group max-w-[280px]">
                    <div
                        class="w-full bg-gray-200 rounded-t-xl rounded-b-xl overflow-hidden shadow-lg relative aspect-3/4 mb-6">
                        <img src="{{ asset('img/2017-12-06.png') }}" alt="Faiz Akhrian Putra" class="w-full h-full object-cover">
                        <!-- Name Bar -->
                        <div class="absolute bottom-0 left-0 w-full bg-[#CEF17B] py-3 text-center">
                            <h4 class="font-bold text-[#084734] text-lg">Faiz Akhrian Putra</h4>
                        </div>
                    </div>
                    <!-- Role Pill -->
                    <div class="px-6 py-2 rounded-full border border-gray-300 text-center w-full max-w-[280px]">
                        <p class="font-bold text-[#3F3D56] text-sm">
                            <span class="block font-extrabold text-[#084734]">FSD</span>
                            <span class="text-gray-500 font-normal text-xs">Full-stack Dev</span>
                        </p>
                    </div>
                </div>

    </section>

    <!-- Seksi CTA -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="reveal-on-scroll bg-[#87D800] rounded-[3rem] p-8 md:p-16 relative overflow-hidden flex flex-col md:flex-row items-center">
                <!-- Left Content -->
                <div class="w-full md:w-1/2 relative z-10 text-left mb-10 md:mb-0">
                    <h2 class="text-3xl md:text-5xl font-bold text-[#084734] mb-6 leading-tight">
                        Gak perlu ragu buat jadi lebih pintar.
                    </h2>
                    <p class="text-[#084734]/80 text-lg md:text-xl font-medium mb-10 max-w-lg leading-relaxed">
                        Mulai perjalanan literasi kamu sekarang juga gratis, verifikasi akun, dan langsung
                        booking buku favorit kamu.
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-block bg-[#084734] text-white px-8 py-4 rounded-xl font-bold hover:bg-brand-600 transition shadow-lg text-lg">
                        Daftar Sekarang
                    </a>
                </div>

                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-white pt-20 pb-10 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <!-- Publishers / Literature Partners -->
            <div class="mb-20">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold mb-6 text-center">Menyediakan koleksi literatur berkualitas</p>
                <div
                    class="flex flex-wrap justify-center items-center gap-16 md:gap-24 grayscale hover:grayscale-0 transition-all duration-500 opacity-60 hover:opacity-100">
                    <img src="{{ asset('img/Gramedia_wordmark.svg') }}" alt="Gramedia" class="h-8 md:h-12 w-auto">
                    <img src="{{ asset('img/Penguin Random House New 2024.svg') }}" alt="Penguin Random House"
                        class="h-10 md:h-16 w-auto">
                    <img src="{{ asset('img/WLF-logo.png') }}" alt="WLF" class="h-10 md:h-14 w-auto">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('img/Logo.svg') }}" alt="Readify" class="h-8 w-auto">
                    </div>
                    <p class="text-gray-500 mb-8 text-sm leading-relaxed">Akses literasi digital untuk semua. Membaca
                        jadi lebih mudah, praktis,
                        dan terintegrasi.</p>
                    <div class="flex gap-4">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Facebook</span>
                            <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Instagram</span>
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                            </svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-[#F5F5F5] flex items-center justify-center text-[#084734] hover:bg-[#87D800] transition">
                            <span class="sr-only">Twitter</span>
                            <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">{{ __('messages.footer_platform') }}</h4>
                    <ul class="space-y-4 text-gray-500 text-sm font-medium">
                        <li><a href="#tentang-kami" class="hover:text-[#87D800] transition">{{ __('messages.nav_about') }}</a></li>
                        <li><a href="#fitur" class="hover:text-[#87D800] transition">{{ __('messages.nav_features') }}</a></li>
                        <li><a href="#katalog" class="hover:text-[#87D800] transition">{{ __('messages.nav_catalog') }}</a></li>
                        <li><a href="#cara-pinjam" class="hover:text-[#87D800] transition">{{ __('messages.nav_how_it_works') }}</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">{{ __('messages.footer_support') }}</h4>
                    <ul class="space-y-4 text-gray-500 text-sm font-medium">
                        <li><a href="#tentang-kami" class="hover:text-[#87D800] transition">{{ __('messages.footer_contact') }}</a></li>
                        <li><a href="#cara-pinjam" class="hover:text-[#87D800] transition">{{ __('messages.nav_how_it_works') }}</a></li>
                        <li><a href="#beranda" class="hover:text-[#87D800] transition">Syarat & Ketentuan</a></li>
                        <li><a href="#beranda" class="hover:text-[#87D800] transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-[#084734] mb-6">{{ __('messages.footer_contact') }}</h4>
                    <ul class="space-y-5 text-gray-500 text-sm font-medium">
                        <li class="flex gap-3 items-start">
                            <span class="text-[#084734] mt-0.5 shrink-0">
                                <svg class="w-5 h-5 text-[#87D800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </span>
                            <span>SMKN 1 Gunungputri<br>Jl. Barokah No.06, Wanaherang, Kec. Gn. Putri, Kabupaten Bogor, Jawa Barat, 40973</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <span class="text-[#084734] shrink-0">
                                <svg class="w-5 h-5 text-[#87D800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span>Readify@readify.id</span>
                        </li>
                        <li class="flex gap-3 items-center">
                            <span class="text-[#084734] shrink-0">
                                <svg class="w-5 h-5 text-[#87D800]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </span>
                            <span>+62 899 8059 878</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Faiz Akhrian Putra.
                </p>
                <div class="flex items-center gap-4 opacity-50">
                    <img src="{{ asset('img/laravel-logolockup-rgb-red.png') }}" alt="Laravel" class="h-5 grayscale">
                    <img src="{{ asset('img/tailwindcss-logotype.svg') }}" alt="Tailwind" class="h-3 grayscale">
                </div>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-on-scroll').forEach((section) => {
                observer.observe(section);
            });

            // Active Link Highlighting
            const sections = document.querySelectorAll('section[id], div[id="beranda"]');
            const navLinks = document.querySelectorAll('.nav-link');

            function highlightNavLink() {
                let current = '';

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    // Offset for sticky header (approx 150px)
                    if (window.scrollY >= (sectionTop - 150)) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    // Reset to inactive state
                    link.classList.remove('text-gray-900', 'font-bold');
                    link.classList.add('text-gray-500', 'font-medium');

                    // Add active state if matches
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.remove('text-gray-500', 'font-medium');
                        link.classList.add('text-gray-900', 'font-bold');
                    }
                });
            }

            window.addEventListener('scroll', highlightNavLink);
            // Call once on load to set initial state
            highlightNavLink();

        });
    </script>

    @include('components.ai-chat-bubble')
</body>

</html>
