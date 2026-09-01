<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LembagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lembaga::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $lembagas = $query->orderBy('tipe')->orderBy('urutan', 'asc')->paginate(10)->withQueryString();
        
        return view('admin.lembaga.index', compact('lembagas'));
    }

    public function create()
    {
        $nextUrutan = Lembaga::max('urutan') + 1;
        return view('admin.lembaga.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tipe' => 'required|in:BPD,PKK',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            Storage::disk('s3')->putFileAs('images/lembaga', $image, $imageName);
            $data['foto'] = $imageName;
        }

        Lembaga::create($data);

        return redirect()->route('admin.lembaga.index')->with('success', 'Anggota lembaga berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $lembaga = Lembaga::findOrFail($id);
        return view('admin.lembaga.edit', compact('lembaga'));
    }

    public function update(Request $request, string $id)
    {
        $lembaga = Lembaga::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tipe' => 'required|in:BPD,PKK',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except(['foto', 'hapus_foto']);

        if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            if ($lembaga->foto && Storage::disk('s3')->exists('images/lembaga/' . $lembaga->foto)) {
                Storage::disk('s3')->delete('images/lembaga/' . $lembaga->foto);
            }
            $data['foto'] = null;
        } elseif ($request->hasFile('foto')) {
            if ($lembaga->foto && Storage::disk('s3')->exists('images/lembaga/' . $lembaga->foto)) {
                Storage::disk('s3')->delete('images/lembaga/' . $lembaga->foto);
            }
            
            $image = $request->file('foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            Storage::disk('s3')->putFileAs('images/lembaga', $image, $imageName);
            $data['foto'] = $imageName;
        }

        $lembaga->update($data);

        return redirect()->route('admin.lembaga.index')->with('success', 'Anggota lembaga berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $lembaga = Lembaga::findOrFail($id);
        
        if ($lembaga->foto && Storage::disk('s3')->exists('images/lembaga/' . $lembaga->foto)) {
            Storage::disk('s3')->delete('images/lembaga/' . $lembaga->foto);
        }
        
        $lembaga->delete();

        return redirect()->route('admin.lembaga.index')->with('success', 'Anggota lembaga berhasil dihapus!');
    }
}
