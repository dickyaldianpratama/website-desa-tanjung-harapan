<?php
namespace App\Http\Controllers;
use App\Models\Berita;
use App\Models\Setting;
class BeritaController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        $kategori = request('kategori');
        
        $query = Berita::publish();
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $beritas = $query->latest('published_at')->paginate(6);
        
        // Ambil daftar kategori unik yang ada di berita yang sudah di-publish
        $kategoris = Berita::publish()->select('kategori')->distinct()->pluck('kategori');
        
        return view('pages.berita.index', compact('settings', 'beritas', 'kategori', 'kategoris'));
    }
    public function show($slug) {
        $settings = Setting::all()->pluck('value', 'key');
        $berita   = Berita::publish()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $berita->increment('views');
        
        $terbaru = Berita::publish()
                    ->where('id', '!=', $berita->id)
                    ->latest('published_at')
                    ->take(5)
                    ->get();
        
        // Ambil daftar kategori unik
        $kategoris = Berita::publish()->select('kategori')->distinct()->pluck('kategori');
        
        return view('pages.berita.show', compact('settings', 'berita', 'terbaru', 'kategoris'));
    }
}
