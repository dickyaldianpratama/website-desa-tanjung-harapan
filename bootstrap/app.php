<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);
        
        // Jika ada tamu (hacker) memaksa masuk ke /admin tanpa login, lempar ke beranda (/)
        // Jangan lempar ke route('login') agar URL rahasianya tidak bocor
        $middleware->redirectGuestsTo(function (Request $request) {
            return url('/');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            return back()->with('error', 'Terlalu banyak permintaan! Sistem mendeteksi aktivitas tidak wajar. Mohon tunggu sekitar 10 menit sebelum mengirim pesan lagi.');
        });
    })->create();
