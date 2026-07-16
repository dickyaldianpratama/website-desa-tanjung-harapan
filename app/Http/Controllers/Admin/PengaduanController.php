<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subjek', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengaduans = $query->latest()->paginate(15)->withQueryString();
        
        $totalBaru = Pengaduan::where('status', 'baru')->count();
        $totalDibaca = Pengaduan::where('status', 'diproses')->count();
        
        return view('admin.pengaduan.index', compact('pengaduans', 'totalBaru', 'totalDibaca'));
    }

    public function show(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Ubah status jadi diproses jika masih baru
        if ($pengaduan->status == 'baru') {
            $pengaduan->update(['status' => 'diproses']);
        }

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function destroy(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')->with('success', 'Pesan pengaduan berhasil dihapus.');
    }
}
