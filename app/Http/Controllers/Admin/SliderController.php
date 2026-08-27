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
        $sliders = Slider::orderBy('urutan', 'asc')->paginate(6);
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        $nextUrutan = Slider::max('urutan') + 1;
        return view('admin.slider.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'          => 'nullable|string|max:60',
            'subtitle'       => 'nullable|string|max:150',
            'gambar'         => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_position' => 'nullable|string|max:50',
            'image_quality'  => 'nullable|integer|min:10|max:100',
            'image_scale'    => 'nullable|integer|min:100|max:300',
            'urutan'         => 'required|integer|min:1',
            'aktif'          => 'required|boolean',
        ]);

        $data = $request->except('gambar');
        $data['image_position'] = $request->input('image_position', '50% 50%');
        $data['image_quality']  = $request->input('image_quality', 85);
        $data['image_scale']    = $request->input('image_scale', 100);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $this->processAndSaveImage(
                $request->file('gambar'),
                (int) $data['image_quality']
            );
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
            'judul'          => 'nullable|string|max:60',
            'subtitle'       => 'nullable|string|max:150',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_position' => 'nullable|string|max:50',
            'image_quality'  => 'nullable|integer|min:10|max:100',
            'image_scale'    => 'nullable|integer|min:100|max:300',
            'urutan'         => 'required|integer|min:1',
            'aktif'          => 'required|boolean',
        ]);

        $data = $request->except('gambar');
        $data['image_position'] = $request->input('image_position', $slider->image_position ?? '50% 50%');
        $data['image_quality']  = $request->input('image_quality', $slider->image_quality ?? 85);
        $data['image_scale']    = $request->input('image_scale', $slider->image_scale ?? 100);

        if ($request->hasFile('gambar')) {
            if ($slider->gambar && File::exists(public_path('images/sliders/' . $slider->gambar))) {
                File::delete(public_path('images/sliders/' . $slider->gambar));
            }
            $data['gambar'] = $this->processAndSaveImage(
                $request->file('gambar'),
                (int) $data['image_quality']
            );
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

    /**
     * Proses gambar: kompres sesuai kualitas lalu simpan ke disk.
     * Mendukung JPEG, PNG, dan WEBP. Gambar disimpan dalam format JPEG.
     */
    private function processAndSaveImage(\Illuminate\Http\UploadedFile $file, int $quality = 85): string
    {
        $destDir = public_path('images/sliders');
        if (!File::isDirectory($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $baseName  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName  = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $baseName) . '.jpg';
        $destPath  = $destDir . '/' . $safeName;

        if (extension_loaded('gd')) {
            $source = match ($extension) {
                'png'  => @imagecreatefrompng($file->getRealPath()),
                'webp' => @imagecreatefromwebp($file->getRealPath()),
                default => @imagecreatefromjpeg($file->getRealPath()),
            };

            if ($source) {
                if ($extension === 'png') {
                    $w  = imagesx($source);
                    $h  = imagesy($source);
                    $bg = imagecreatetruecolor($w, $h);
                    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                    imagecopy($bg, $source, 0, 0, 0, 0, $w, $h);
                    imagedestroy($source);
                    $source = $bg;
                }
                imagejpeg($source, $destPath, $quality);
                imagedestroy($source);
                return $safeName;
            }
        }

        $file->move($destDir, $safeName);
        return $safeName;
    }
}
