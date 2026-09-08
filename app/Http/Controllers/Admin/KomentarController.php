<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index()
    {
        // Ambil semua komentar, urutkan dari yang terbaru
        $komentars = Komentar::with('berita')->latest()->get();
        return view('admin.komentar.index', compact('komentars'));
    }

    public function approve($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->update(['status' => 'approved']);
        return back()->with('success', 'Komentar berhasil disetujui dan kini tampil di website.');
    }

    public function destroy($id)
    {
        $komentar = Komentar::findOrFail($id);
        $komentar->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
