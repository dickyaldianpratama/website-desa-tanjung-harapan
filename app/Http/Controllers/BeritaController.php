<?php
namespace App\Http\Controllers;
use App\Models\Berita;
use App\Models\Setting;
class BeritaController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        $beritas  = Berita::publish()->latest('published_at')->paginate(6);
        $kategori = request('kategori');
        if ($kategori) $beritas = Berita::publish()->where('kategori', $kategori)->latest('published_at')->paginate(6);
        return view('pages.berita.index', compact('settings', 'beritas', 'kategori'));
    }
    public function show($slug) {
        $settings = Setting::all()->pluck('value', 'key');
        $berita   = Berita::publish()->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $berita->increment('views');
        
        $related  = Berita::publish()->where('kategori', $berita->kategori)->where('id', '!=', $berita->id)->take(3)->get();
        return view('pages.berita.show', compact('settings', 'berita', 'related'));
    }
}
