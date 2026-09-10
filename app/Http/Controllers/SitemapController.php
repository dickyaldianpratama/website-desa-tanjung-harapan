<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Potensi;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        $potensi = Potensi::latest()->get();

        return response()->view('sitemap', [
            'berita' => $berita,
            'potensi' => $potensi
        ])->header('Content-Type', 'text/xml');
    }
}
