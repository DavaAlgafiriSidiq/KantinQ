<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Untuk mengarahkan pengguna yang belum terautentikasi ke halaman login yang sesuai berdasarkan URL yang mereka akses
        $middleware->redirectGuestsTo(function (Request $request) {
            // Periksa apakah URL yang diakses adalah untuk seller
            if ($request->is('seller') || $request->is('seller/*')) {
                return route('login-seller'); // Arahkan ke rute login khusus seller
            }

            // Default: lempar ke rute login utama (jika ada)
            return route('login-seller'); // Arahkan ke rute login utama (bisa disesuaikan jika ada rute login umum)
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
