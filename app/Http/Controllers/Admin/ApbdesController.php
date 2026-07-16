<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;

class ApbdesController extends Controller
{
    public function index()
    {
        $apbdes = Apbdes::orderBy('tahun', 'desc')->orderBy('jenis', 'desc')->get();
        return view('admin.apbdes.index', compact('apbdes'));
    }

    public function create()
    {
        return view('admin.apbdes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'     => 'required|integer',
            'uraian'    => 'required|string|max:255',
            'jenis'     => 'required|in:pendapatan,belanja',
            'anggaran'  => 'required|numeric',
            'realisasi' => 'required|numeric',
        ]);

        // Hapus karakter non-numerik jika terkirim dari frontend
        $anggaran = preg_replace('/\D/', '', $request->anggaran);
        $realisasi = preg_replace('/\D/', '', $request->realisasi);

        Apbdes::create([
            'tahun'     => $request->tahun,
            'uraian'    => $request->uraian,
            'jenis'     => $request->jenis,
            'anggaran'  => $anggaran,
            'realisasi' => $realisasi,
        ]);

        return redirect()->route('admin.apbdes.index')->with('success', 'Data APBDes berhasil ditambahkan!');
    }

    public function edit(Apbdes $apbde) // Laravel implicitly passes the singular form 'apbde' based on 'apbdes'
    {
        return view('admin.apbdes.edit', compact('apbde'));
    }

    public function update(Request $request, Apbdes $apbde)
    {
        $request->validate([
            'tahun'     => 'required|integer',
            'uraian'    => 'required|string|max:255',
            'jenis'     => 'required|in:pendapatan,belanja',
            'anggaran'  => 'required',
            'realisasi' => 'required',
        ]);

        $anggaran = preg_replace('/\D/', '', $request->anggaran);
        $realisasi = preg_replace('/\D/', '', $request->realisasi);

        $apbde->update([
            'tahun'     => $request->tahun,
            'uraian'    => $request->uraian,
            'jenis'     => $request->jenis,
            'anggaran'  => $anggaran,
            'realisasi' => $realisasi,
        ]);

        return redirect()->route('admin.apbdes.index')->with('success', 'Data APBDes berhasil diperbarui!');
    }

    public function destroy(Apbdes $apbde)
    {
        $apbde->delete();
        return redirect()->route('admin.apbdes.index')->with('success', 'Data APBDes berhasil dihapus!');
    }
}
