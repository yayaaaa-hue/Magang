<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Mengatur arah redirect otomatis bagi pengguna yang sudah login ke halaman utama (/)
        // agar diarahkan secara dinamis sesuai role (admin, mahasiswa, pegawai) tanpa error 404
        $middleware->redirectTo(
            guests: '/login',
            users: '/'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();