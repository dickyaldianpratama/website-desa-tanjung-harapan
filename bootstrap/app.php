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
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (\Throwable $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'REAL_ERROR' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            exit;
        });
        
        $exceptions->shouldRenderJsonWhen(
            fn () => true // FORCE JSON FOR VERCEL DEBUGGING
        );
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            return back()->with('error', 'Terlalu banyak permintaan! Sistem mendeteksi aktivitas tidak wajar. Mohon tunggu sekitar 10 menit sebelum mengirim pesan lagi.');
        });
    })->create();
