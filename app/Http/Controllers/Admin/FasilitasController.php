<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        // Kategori bawaan
        $kategoriList = ['Kesehatan', 'Pendidikan', 'Ibadah', 'Olahraga', 'Umum'];
        return view('admin.fasilitas.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:150',
            'kategori'       => 'required|string|max:100',
            'deskripsi'      => 'nullable|string|max:400',
            'foto'           => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($request->nama_fasilitas) . '.' . $image->getClientOriginalExtension();
            Storage::disk('s3')->putFileAs('images/fasilitas', $image, $imageName);
            $data['foto'] = $imageName;
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Data Fasilitas berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $kategoriList = ['Kesehatan', 'Pendidikan', 'Ibadah', 'Olahraga', 'Umum'];
        return view('admin.fasilitas.edit', compact('fasilitas', 'kategoriList'));
    }

    public function update(Request $request, string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:150',
            'kategori'       => 'required|string|max:100',
            'deskripsi'      => 'nullable|string|max:400',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($fasilitas->foto) {
                Storage::disk('s3')->delete('images/fasilitas/' . $fasilitas->foto);
            }

            $image = $request->file('foto');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($request->nama_fasilitas) . '.' . $image->getClientOriginalExtension();
            Storage::disk('s3')->putFileAs('images/fasilitas', $image, $imageName);
            $data['foto'] = $imageName;
        }

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')->with('success', 'Data Fasilitas berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        if ($fasilitas->foto) {
            Storage::disk('s3')->delete('images/fasilitas/' . $fasilitas->foto);
        }
        
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')->with('success', 'Data Fasilitas berhasil dihapus!');
    }
}
