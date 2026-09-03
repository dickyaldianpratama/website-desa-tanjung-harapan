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
            'jenis_layanan'          => 'required|string|max:150',
            'jenis_layanan_lainnya'  => 'required_if:jenis_layanan,Lainnya|nullable|string|max:150',
            'nik'                    => 'required|numeric|digits:16',
            'nama_lengkap'           => 'required|string|max:150',
            'no_whatsapp'            => 'required|numeric|digits:12',
            'keperluan'              => 'nullable|string',
            'file_lampiran'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nik.digits'                       => 'NIK wajib berisi tepat 16 angka.',
            'nik.numeric'                      => 'NIK hanya boleh berupa angka.',
            'no_whatsapp.digits'               => 'Nomor WhatsApp wajib berisi tepat 12 angka.',
            'no_whatsapp.numeric'              => 'Nomor WhatsApp hanya boleh berupa angka.',
            'jenis_layanan_lainnya.required_if'=> 'Jenis layanan wajib diisi jika Anda memilih "Lainnya".',
            'file_lampiran.required'           => 'Foto KTP wajib diunggah.',
            'file_lampiran.image'              => 'File harus berupa gambar (JPG/PNG).',
            'file_lampiran.max'                => 'Ukuran foto KTP maksimal 2 MB.',
        ]);

        // Jika pilih "Lainnya", ganti nilai jenis_layanan dengan isian bebas
        if ($request->jenis_layanan === 'Lainnya') {
            $request->merge(['jenis_layanan' => $request->jenis_layanan_lainnya]);
        }

        // --- ANTI SPAM CHECK: 1 Tiket Pending per NIK ---
        $hasPending = Layanan::where('nik', $request->nik)->where('status', 'pending')->exists();
        if ($hasPending) {
            return back()->withInput()->with('error', 'Maaf, NIK Anda masih memiliki pengajuan layanan yang sedang diproses. Harap tunggu hingga selesai.');
        }

        $data = $request->except(['file_lampiran', 'jenis_layanan_lainnya']);
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
            $inputted = $request->nomor_tiket;
            $trimmed  = trim($inputted);
            $upper    = strtoupper($trimmed);

            $tips = 'Nomor Tiket <strong>"' . e($inputted) . '"</strong> tidak ditemukan.<br><br>'
                  . '<strong>Kemungkinan penyebabnya:</strong><ul style="text-align:left;margin-top:6px;">';

            if ($inputted !== $trimmed) {
                $tips .= '<li>Ada <strong>spasi di awal atau akhir</strong> nomor tiket. Coba hapus spasi tersebut.</li>';
            }
            if ($inputted !== $upper) {
                $tips .= '<li>Huruf harus <strong>KAPITAL SEMUA</strong>. Contoh: <code>SRT-202608-001</code></li>';
            }
            $tips .= '<li>Pastikan format penulisannya benar: <code>SRT-202608-001</code> (ada tanda hubung <strong>-</strong>, bukan titik atau spasi).</li>';
            $tips .= '<li>Cek kembali nomor tiket di <strong>foto/screenshot</strong> yang Anda simpan sebelumnya.</li>';
            $tips .= '</ul>';

            return back()->withInput()->with('error', $tips);
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
