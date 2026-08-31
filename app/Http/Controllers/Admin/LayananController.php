<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.layanan.index', compact('layanans'));
    }

    public function show($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.show', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'nomor_surat' => 'nullable|string|max:100',
            'catatan_admin' => 'nullable|string'
        ]);

        $layanan->update([
            'status' => $request->status,
            'nomor_surat' => $request->nomor_surat,
            'catatan_admin' => $request->catatan_admin
        ]);

        return redirect()->route('admin.layanan.show', $layanan->id)
            ->with('success', 'Status permohonan surat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        if ($layanan->file_lampiran && file_exists(public_path('images/layanan/'.$layanan->file_lampiran))) {
            @unlink(public_path('images/layanan/'.$layanan->file_lampiran));
        }
        $layanan->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Data permohonan berhasil dihapus.');
    }

    public function downloadLampiran($id)
    {
        $layanan = Layanan::findOrFail($id);

        if (!$layanan->file_lampiran) {
            abort(404, 'File lampiran tidak ditemukan.');
        }

        $fileLampiran = $layanan->file_lampiran;

        // Bangun URL publik Supabase
        $supabaseUrl = rtrim(env('SUPABASE_URL', ''), '/');
        $bucket      = env('SUPABASE_BUCKET', 'public-images');
        $fileUrl     = "{$supabaseUrl}/storage/v1/object/public/{$bucket}/layanan/{$fileLampiran}";

        // Ambil konten file dari Supabase
        $fileContent = @file_get_contents($fileUrl);

        if ($fileContent === false) {
            abort(404, 'File tidak dapat diunduh dari server.');
        }

        // Deteksi ekstensi
        $ext      = pathinfo($fileLampiran, PATHINFO_EXTENSION) ?: 'jpg';
        $mimeMap  = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'pdf' => 'application/pdf'];
        $mimeType = $mimeMap[strtolower($ext)] ?? 'application/octet-stream';

        $downloadName = 'lampiran-' . $layanan->nomor_tiket . '.' . $ext;

        return response($fileContent, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"')
            ->header('Content-Length', strlen($fileContent));
    }
}
