<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaganStruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BaganStrukturController extends Controller
{
    public function index()
    {
        $bagans = BaganStruktur::orderBy('urutan', 'asc')->get();
        return view('admin.bagan.index', compact('bagans'));
    }

    public function create()
    {
        $nextUrutan = BaganStruktur::max('urutan') + 1;
        return view('admin.bagan.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            Storage::disk('s3')->putFileAs('images/struktur', $image, $imageName);
            $data['gambar'] = $imageName;
        }

        BaganStruktur::create($data);

        return redirect()->route('admin.bagan.index')->with('success', 'Bagan struktur berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $bagan = BaganStruktur::findOrFail($id);
        return view('admin.bagan.edit', compact('bagan'));
    }

    public function update(Request $request, string $id)
    {
        $bagan = BaganStruktur::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($bagan->gambar && Storage::disk('s3')->exists('images/struktur/' . $bagan->gambar)) {
                Storage::disk('s3')->delete('images/struktur/' . $bagan->gambar);
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            Storage::disk('s3')->putFileAs('images/struktur', $image, $imageName);
            $data['gambar'] = $imageName;
        }

        $bagan->update($data);

        return redirect()->route('admin.bagan.index')->with('success', 'Bagan struktur berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $bagan = BaganStruktur::findOrFail($id);
        
        if ($bagan->gambar && Storage::disk('s3')->exists('images/struktur/' . $bagan->gambar)) {
            Storage::disk('s3')->delete('images/struktur/' . $bagan->gambar);
        }
        
        $bagan->delete();

        return redirect()->route('admin.bagan.index')->with('success', 'Bagan struktur berhasil dihapus!');
    }
}
