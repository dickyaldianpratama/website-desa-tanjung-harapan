<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

$folders = ['berita', 'lembaga', 'perangkat', 'potensi', 'slider', 'pengaduan'];
foreach ($folders as $folder) {
    $path = public_path('images/' . $folder);
    if (File::isDirectory($path)) {
        $files = File::files($path);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $s3Path = 'images/' . $folder . '/' . $filename;
            if (!Storage::disk('s3')->exists($s3Path)) {
                echo 'Uploading: ' . $s3Path . PHP_EOL;
                Storage::disk('s3')->put($s3Path, file_get_contents($file->getPathname()));
            } else {
                echo 'Skipping existing: ' . $s3Path . PHP_EOL;
            }
        }
    }
}
echo "Done!\n";
