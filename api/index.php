<?php
    // Force Laravel to use /tmp for views and cache on Vercel
    $tmpPaths = [
        'VIEW_COMPILED_PATH' => '/tmp',
        'CACHE_STORE' => 'array',
        'APP_SERVICES_CACHE' => '/tmp/services.php',
        'APP_PACKAGES_CACHE' => '/tmp/packages.php',
        'APP_CONFIG_CACHE' => '/tmp/config.php',
        'APP_ROUTES_CACHE' => '/tmp/routes-v7.php',
        'APP_EVENTS_CACHE' => '/tmp/events.php',
    ];

    foreach ($tmpPaths as $key => $value) {
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }

    require __DIR__ . '/../public/index.php';
