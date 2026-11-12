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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem 1rem;
            box-sizing: border-box;
            margin: 0;
            position: relative;
            background-color: #f8fafc;
        }

        /* Ambient Library Background with Blur */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 20%, rgba(0, 66, 54, 0.08) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(15, 76, 58, 0.06) 0%, transparent 40%),
                        url('/img/bg-auth.jpg') no-repeat center center;
            background-size: cover;
            filter: blur(10px);
            z-index: -1;
            transform: scale(1.08);
        }

        .glass-auth-container {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            box-shadow: 0 20px 50px -10px rgba(0, 66, 54, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.8);
            width: 100%;
            max-width: 1060px;
            position: relative;
            z-index: 10;
            margin: auto;
            overflow: hidden;
        }

        .form-control-glass {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 13px 16px;
            width: 100%;
            box-sizing: border-box;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            outline: none;
            color: #0f172a;
        }

        .form-control-glass:focus {
            background: #ffffff;
            border-color: #004236;
            box-shadow: 0 0 0 3px rgba(0, 66, 54, 0.12);
        }

        .btn-primary-glass {
            background: #004236;
            color: white;
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

        .btn-primary-glass:hover {
            background: #003128;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 66, 54, 0.25);
        }

        .btn-primary-glass:active {
            transform: translateY(0);
        }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.85rem;
            color: #1e293b;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.15rem;
            position: relative;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #64748b;
        }

        .auth-footer a {
            color: #004236;
            text-decoration: none;
            font-weight: 700;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Language Switcher Pill -->
    <div class="fixed top-4 right-4 z-50">
        <div class="inline-flex items-center rounded-xl bg-white/90 backdrop-blur-md p-1 shadow-md border border-gray-200/80">
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

    <!-- Main Container -->
    <div class="glass-auth-container">
        @yield('content')
    </div>
</body>

</html>
