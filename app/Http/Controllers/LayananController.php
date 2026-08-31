<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Layanan;

class LayananController extends Controller
{
    public function index()
    {
        return view('pages.layanan.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan' => 'required|string|max:150',
            'nik'           => 'required|numeric|digits:16',
            'nama_lengkap'  => 'required|string|max:150',
            'no_whatsapp'   => 'required|string|max:20',
            'keperluan'     => 'nullable|string',
            'file_lampiran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional
        ]);

        // --- ANTI SPAM CHECK: 1 Tiket Pending per NIK ---
        $hasPending = Layanan::where('nik', $request->nik)->where('status', 'pending')->exists();
        if ($hasPending) {
            return back()->withInput()->with('error', 'Maaf, NIK Anda masih memiliki pengajuan layanan yang sedang diproses. Harap tunggu hingga selesai.');
        }

        $data = $request->except('file_lampiran');
        $data['nomor_tiket'] = Layanan::generateTiket();
        $data['status'] = 'pending';

        if ($request->hasFile('file_lampiran')) {
            $file = $request->file('file_lampiran');
            $fileName = $file->hashName();
            
            // Upload ke Supabase Storage
            $file->storeAs('layanan', $fileName, 'supabase');
            
            $data['file_lampiran'] = $fileName;
        }

        $layanan = Layanan::create($data);

        return redirect()->route('layanan.cek')
            ->with('success', 'Pengajuan berhasil dikirim! Nomor Tiket Anda: <strong>' . $layanan->nomor_tiket . '</strong>.<br><a href="'.route('layanan.cetakTiket', $layanan->nomor_tiket).'" target="_blank" class="btn btn-sm btn-dark mt-2"><i class="bi bi-printer"></i> Cetak/Simpan Tiket</a>');
    }

    public function cek()
    {
        return view('pages.layanan.cek');
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nomor_tiket' => 'required|string',
        ]);

        $layanan = Layanan::where('nomor_tiket', $request->nomor_tiket)->first();

        if (!$layanan) {
            return back()->with('error', 'Nomor Tiket tidak ditemukan.');
        }

        return view('pages.layanan.cek', compact('layanan'));
    }

    public function cetakTiket($nomor_tiket)
    {
        $layanan = Layanan::where('nomor_tiket', $nomor_tiket)->firstOrFail();
        return view('pages.layanan.cetak-tiket', compact('layanan'));
    }

    public function cetakSurat($nomor_tiket)
    {
        $layanan = Layanan::where('nomor_tiket', $nomor_tiket)->firstOrFail();
        
        if ($layanan->status !== 'selesai') {
            abort(403, 'Surat belum selesai diproses.');
        }

        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('pages.layanan.cetak-surat', compact('layanan', 'settings'));
    }
}
