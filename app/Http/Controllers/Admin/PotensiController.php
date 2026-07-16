<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potensi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PotensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Potensi::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('kategori', 'like', '%' . $request->search . '%');
        }

        $potensis = $query->latest()->paginate(6)->withQueryString();
        
        return view('admin.potensi.index', compact('potensis'));
    }

    public function create()
    {
        return view('admin.potensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('gambar');
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/potensi'), $imageName);
            $data['gambar'] = $imageName;
        }

        Potensi::create($data);

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $potensi = Potensi::findOrFail($id);
        return view('admin.potensi.edit', compact('potensi'));
    }

    public function update(Request $request, string $id)
    {
        $potensi = Potensi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('gambar');
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            if ($potensi->gambar && File::exists(public_path('images/potensi/' . $potensi->gambar))) {
                File::delete(public_path('images/potensi/' . $potensi->gambar));
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/potensi'), $imageName);
            $data['gambar'] = $imageName;
        }

        $potensi->update($data);

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $potensi = Potensi::findOrFail($id);
        
        if ($potensi->gambar && File::exists(public_path('images/potensi/' . $potensi->gambar))) {
            File::delete(public_path('images/potensi/' . $potensi->gambar));
        }
        
        $potensi->delete();

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil dihapus!');
    }
}
