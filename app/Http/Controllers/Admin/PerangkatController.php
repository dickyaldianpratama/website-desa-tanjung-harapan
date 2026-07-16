<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PerangkatController extends Controller
{
    public function index(Request $request)
    {
        $query = Perangkat::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->search . '%');
        }

        $perangkats = $query->orderBy('urutan', 'asc')->paginate(8)->withQueryString();
        
        return view('admin.perangkat.index', compact('perangkats'));
    }

    public function create()
    {
        $nextUrutan = Perangkat::max('urutan') + 1;
        return view('admin.perangkat.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/perangkat'), $imageName);
            $data['foto'] = $imageName;
        }

        Perangkat::create($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Data perangkat desa berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $perangkat = Perangkat::findOrFail($id);
        return view('admin.perangkat.edit', compact('perangkat'));
    }

    public function update(Request $request, string $id)
    {
        $perangkat = Perangkat::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'nip' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'urutan' => 'required|integer|min:1',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($perangkat->foto && File::exists(public_path('images/perangkat/' . $perangkat->foto))) {
                File::delete(public_path('images/perangkat/' . $perangkat->foto));
            }
            
            $image = $request->file('foto');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/perangkat'), $imageName);
            $data['foto'] = $imageName;
        }

        $perangkat->update($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Data perangkat desa berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $perangkat = Perangkat::findOrFail($id);
        
        if ($perangkat->foto && File::exists(public_path('images/perangkat/' . $perangkat->foto))) {
            File::delete(public_path('images/perangkat/' . $perangkat->foto));
        }
        
        $perangkat->delete();

        return redirect()->route('admin.perangkat.index')->with('success', 'Data perangkat desa berhasil dihapus!');
    }
}
