<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $tipe = $request->input('tipe_media', 'gambar');

        $rules = [
            'judul'          => 'nullable|string|max:60',
            'subtitle'       => 'nullable|string|max:150',
            'tipe_media'     => 'required|in:gambar,video',
            'urutan'         => 'required|integer|min:1',
            'aktif'          => 'required|boolean',
        ];

        if ($tipe === 'video') {
            $rules['gambar'] = 'required|file|mimes:mp4,webm|max:51200'; // 50 MB
        } else {
            $rules['gambar']         = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
            $rules['image_position'] = 'nullable|string|max:50';
            $rules['image_quality']  = 'nullable|integer|min:10|max:100';
            $rules['image_scale']    = 'nullable|integer|min:100|max:300';
        }

        $request->validate($rules);

        $data = $request->except('gambar');

        if ($tipe === 'gambar') {
            $data['image_position'] = $request->input('image_position', '50% 50%');
            $data['image_quality']  = $request->input('image_quality', 85);
            $data['image_scale']    = $request->input('image_scale', 100);
        }

        if ($request->hasFile('gambar')) {
            if ($tipe === 'video') {
                $data['gambar'] = $this->saveVideo($request->file('gambar'));
            } else {
                $data['gambar'] = $this->processAndSaveImage(
                    $request->file('gambar'),
                    (int) $data['image_quality']
                );
            }
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
        $tipe   = $request->input('tipe_media', $slider->tipe_media ?? 'gambar');

        $rules = [
            'judul'      => 'nullable|string|max:60',
            'subtitle'   => 'nullable|string|max:150',
            'tipe_media' => 'required|in:gambar,video',
            'urutan'     => 'required|integer|min:1',
            'aktif'      => 'required|boolean',
        ];

        if ($tipe === 'video') {
            $rules['gambar'] = 'nullable|file|mimes:mp4,webm|max:51200';
        } else {
            $rules['gambar']         = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
            $rules['image_position'] = 'nullable|string|max:50';
            $rules['image_quality']  = 'nullable|integer|min:10|max:100';
            $rules['image_scale']    = 'nullable|integer|min:100|max:300';
        }

        $request->validate($rules);

        $data = $request->except('gambar');

        if ($tipe === 'gambar') {
            $data['image_position'] = $request->input('image_position', $slider->image_position ?? '50% 50%');
            $data['image_quality']  = $request->input('image_quality', $slider->image_quality ?? 85);
            $data['image_scale']    = $request->input('image_scale', $slider->image_scale ?? 100);
        }

        if ($request->hasFile('gambar')) {
            // Hapus file lama
            if ($slider->gambar && Storage::disk('s3')->exists('images/sliders/' . $slider->gambar)) {
                Storage::disk('s3')->delete('images/sliders/' . $slider->gambar);
            }

            if ($tipe === 'video') {
                $data['gambar'] = $this->saveVideo($request->file('gambar'));
            } else {
                $data['gambar'] = $this->processAndSaveImage(
                    $request->file('gambar'),
                    (int) $data['image_quality']
                );
            }
        }

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Banner berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->gambar && Storage::disk('s3')->exists('images/sliders/' . $slider->gambar)) {
            Storage::disk('s3')->delete('images/sliders/' . $slider->gambar);
        }

        $slider->delete();

        return redirect()->route('admin.slider.index')->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Simpan file video langsung ke S3 tanpa kompresi.
     */
    private function saveVideo(\Illuminate\Http\UploadedFile $file): string
    {
        $ext      = strtolower($file->getClientOriginalExtension());
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $baseName) . '.' . $ext;

        Storage::disk('s3')->putFileAs('images/sliders', $file, $safeName);
        return $safeName;
    }

    /**
     * Proses gambar: kompres sesuai kualitas lalu simpan ke S3.
     * Mendukung JPEG, PNG, dan WEBP. Gambar disimpan dalam format JPEG.
     */
    private function processAndSaveImage(\Illuminate\Http\UploadedFile $file, int $quality = 85): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $baseName  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName  = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $baseName) . '.jpg';
        $tempPath  = sys_get_temp_dir() . '/' . $safeName;

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
                imagejpeg($source, $tempPath, $quality);
                imagedestroy($source);
                
                Storage::disk('s3')->put('images/sliders/' . $safeName, file_get_contents($tempPath));
                @unlink($tempPath);
                return $safeName;
            }
        }

        Storage::disk('s3')->putFileAs('images/sliders', $file, $safeName);
        return $safeName;
    }
}

