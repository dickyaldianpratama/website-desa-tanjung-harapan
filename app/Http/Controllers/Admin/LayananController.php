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
}
