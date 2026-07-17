<?php
try {
    // Force Laravel to use /tmp for views and array for cache on Vercel
    putenv('VIEW_COMPILED_PATH=/tmp');
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp';
    $_SERVER['VIEW_COMPILED_PATH'] = '/tmp';

    putenv('CACHE_STORE=array');
    $_ENV['CACHE_STORE'] = 'array';
    $_SERVER['CACHE_STORE'] = 'array';

    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
}
