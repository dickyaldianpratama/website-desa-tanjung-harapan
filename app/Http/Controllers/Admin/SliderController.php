<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    public function index()
    {
        // Pagination ditambahkan agar banner tidak menumpuk ke bawah jika sudah banyak
        $sliders = Slider::orderBy('urutan', 'asc')->paginate(6);
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        // Mendapatkan urutan terakhir untuk default value
        $nextUrutan = Slider::max('urutan') + 1;
        return view('admin.slider.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:60',
            'subtitle' => 'nullable|string|max:150',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan' => 'required|integer|min:1',
            'aktif' => 'required|boolean'
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/sliders'), $imageName);
            $data['gambar'] = $imageName;
        }

        Slider::create($data);

        return redirect()->route('admin.slider.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:60',
            'subtitle' => 'nullable|string|max:150',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'urutan' => 'required|integer|min:1',
            'aktif' => 'required|boolean'
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($slider->gambar && File::exists(public_path('images/sliders/' . $slider->gambar))) {
                File::delete(public_path('images/sliders/' . $slider->gambar));
            }
            
            $image = $request->file('gambar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/sliders'), $imageName);
            $data['gambar'] = $imageName;
        }

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        
        if ($slider->gambar && File::exists(public_path('images/sliders/' . $slider->gambar))) {
            File::delete(public_path('images/sliders/' . $slider->gambar));
        }
        
        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Banner berhasil dihapus!');
    }
}
