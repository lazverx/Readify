<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\SetLocaleMiddleware::class,
        ]);

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'akses' => \App\Http\Middleware\CekHakAkses::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        $middleware->redirectUsersTo(function () {
            if (auth()->user()->isAdmin())
                return route('dashboard');
            if (auth()->user()->isPetugas())
                return route('petugas.dashboard');
            if (auth()->user()->isAnggota())
                return route('anggota.dashboard');
            return url('/');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Support for serverless environments (such as Vercel)
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL')) {
    $storage = '/tmp/storage';
    foreach ([
        $storage . '/framework/views',
        $storage . '/framework/cache',
        $storage . '/framework/cache/data',
        $storage . '/framework/sessions',
        $storage . '/logs',
    ] as $path) {
        if (!is_dir($path)) {
            @mkdir($path, 0755, true);
        }
    }
    $app->useStoragePath($storage);
}

return $app;
