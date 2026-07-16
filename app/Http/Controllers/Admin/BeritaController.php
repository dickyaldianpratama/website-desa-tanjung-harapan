<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('published_at', $request->tanggal);
        }

        // Menampilkan 5 berita per halaman agar pagination mudah terlihat
        $beritas = $query->latest('published_at')->paginate(5)->withQueryString();
        
        return view('admin.berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:publish,draft',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('gambar');
        $data['slug'] = Str::slug($request->judul);
        $data['penulis'] = 'Admin Desa';
        
        if ($request->status == 'publish') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/berita'), $imageName);
            $data['gambar'] = $imageName;
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:publish,draft',
            'isi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('gambar');
        $data['slug'] = Str::slug($request->judul);

        // Jika mengubah dari draft ke publish, set published_at
        if ($berita->status == 'draft' && $request->status == 'publish' && !$berita->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar && File::exists(public_path('images/berita/' . $berita->gambar))) {
                File::delete(public_path('images/berita/' . $berita->gambar));
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/berita'), $imageName);
            $data['gambar'] = $imageName;
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->gambar && File::exists(public_path('images/berita/' . $berita->gambar))) {
            File::delete(public_path('images/berita/' . $berita->gambar));
        }
        
        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
