<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autentikasi' }} | {{ config('app.name', 'Readify') }}</title>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #FAF8F5;
            color: #1C1917;
        }

        .auth-input {
            width: 100%;
            border-radius: 14px;
            border: 1px solid #EFECE6;
            background-color: #FFFFFF;
            padding: 13px 16px;
            font-size: 0.875rem;
            color: #1C1917;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .auth-input:focus {
            background-color: #ffffff;
            border-color: #004236;
            box-shadow: 0 0 0 3px rgba(0, 66, 54, 0.12);
        }

        .auth-btn-primary {
            background-color: #004236;
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 14px 20px;
            width: 100%;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 48px;
        }

        .auth-btn-primary:hover {
            background-color: #003128;
            box-shadow: 0 8px 20px -4px rgba(0, 66, 54, 0.3);
        }

        .auth-btn-primary:active {
            transform: scale(0.99);
        }
    </style>
</head>

<body class="min-h-screen w-full flex flex-col bg-white antialiased">
    <!-- Language Switcher Pill (Top Right) -->
    <div class="fixed top-4 right-4 z-50">
        <div class="inline-flex items-center rounded-xl bg-white/90 backdrop-blur-md p-1 shadow-sm border border-[#EFECE6]">
            <a href="{{ route('lang.switch', 'id') }}"
               class="px-2.5 py-1 text-xs font-bold rounded-lg transition-all {{ app()->getLocale() === 'id' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                ID
            </a>
            <a href="{{ route('lang.switch', 'en') }}"
               class="px-2.5 py-1 text-xs font-bold rounded-lg transition-all {{ app()->getLocale() === 'en' ? 'bg-[#004236] text-white shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                EN
            </a>
        </div>
    </div>

    <!-- Full-Page Main Content View (Edge to Edge 100vh) -->
    <main class="w-full flex-1 flex flex-col">
        @yield('content')
    </main>
</body>

</html>
