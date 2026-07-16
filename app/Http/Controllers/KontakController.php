<?php
namespace App\Http\Controllers;
use App\Models\Pengaduan;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Models\Berita;

class KontakController extends Controller {
    public function index() {
        $settings = Setting::all()->pluck('value', 'key');
        $beritas = Berita::publish()->latest('published_at')->take(4)->get();
        return view('pages.kontak', compact('settings', 'beritas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'telepon'  => 'required|string|max:20',
            'subjek'   => 'required|string|max:200', // Saran/Aduan
            'kategori' => 'required|string|max:100',
            'pesan'    => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $data = $request->only('nama','telepon','subjek','kategori','pesan');

        // Handle File Upload
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/pengaduan'), $filename);
            $data['lampiran'] = $filename;
        }

        // Save to Database
        Pengaduan::create($data);

        // Prepare WhatsApp Redirection
        $settings = Setting::all()->pluck('value', 'key');
        $noWaAdmin = $settings['telepon'] ?? '6281234567890';
        
        // Ensure number starts with 62
        $noWaAdmin = preg_replace('/[^0-9]/', '', $noWaAdmin);
        if(str_starts_with($noWaAdmin, '0')) {
            $noWaAdmin = '62' . substr($noWaAdmin, 1);
        }

        $teksWa = "Halo Admin Desa,\n\nSaya ingin menyampaikan *" . strtoupper($request->subjek) . "*.\n\n" .
                  "👤 *Nama:* " . $request->nama . "\n" .
                  "📞 *Telepon:* " . $request->telepon . "\n" .
                  "📑 *Kategori:* " . $request->kategori . "\n\n" .
                  "📝 *Pesan:*\n" . $request->pesan;

        $waLink = "https://api.whatsapp.com/send?phone=" . $noWaAdmin . "&text=" . urlencode($teksWa);

        return back()->with('success', 'Formulir berhasil disubmit! Mengalihkan ke WhatsApp...')->with('wa_link', $waLink);
    }
}
