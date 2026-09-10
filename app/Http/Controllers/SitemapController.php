<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\Potensi;

class SitemapController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        $potensi = Potensi::latest()->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static routes
        $statics = ['/', '/profil', '/berita', '/potensi', '/fasilitas', '/layanan', '/kontak'];
        foreach ($statics as $route) {
            $xml .= '<url>';
            $xml .= '<loc>' . url($route) . '</loc>';
            $xml .= '<lastmod>' . now()->tz('UTC')->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>' . ($route == '/' ? '1.0' : '0.8') . '</priority>';
            $xml .= '</url>';
        }

        // Berita
        foreach ($berita as $item) {
            $lastmod = $item->updated_at ? $item->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString();
            $xml .= '<url>';
            $xml .= '<loc>' . url('/berita/' . $item->slug) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        // Potensi
        foreach ($potensi as $item) {
            $lastmod = $item->updated_at ? $item->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString();
            $xml .= '<url>';
            $xml .= '<loc>' . url('/potensi/' . $item->slug) . '</loc>';
            $xml .= '<lastmod>' . $lastmod . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml)->header('Content-Type', 'text/xml');
    }
}
