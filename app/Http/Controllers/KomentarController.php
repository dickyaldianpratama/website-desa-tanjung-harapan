<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KomentarController extends Controller
{
    // Daftar kata kotor sederhana berbahasa Indonesia
    private $badWords = [
        'anjing', 'babi', 'bangsat', 'kontol', 'memek', 'jembut', 
        'ngentot', 'perek', 'pelacur', 'sialan', 'kampret', 'tolol', 
        'goblok', 'bego', 'idiot', 'bajingan', 'asu', 'jancok', 'pantat', 'taik', 'tai'
    ];

    public function store(Request $request, $slug)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'required|string|max:20',
            'isi' => 'required|string',
            'captcha' => 'required|string'
        ]);

        // Verifikasi Captcha
        $sessionCaptcha = session('komentar_captcha');
        if (!$sessionCaptcha || strtolower($request->captcha) !== strtolower($sessionCaptcha)) {
            return back()->with('error', 'Kode captcha tidak sesuai. Silakan coba lagi.')->withInput();
        }

        // Cari berita
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Filter kata kasar
        $isSpam = false;
        $isiLower = strtolower($request->isi);
        foreach ($this->badWords as $badWord) {
            if (strpos($isiLower, $badWord) !== false) {
                $isSpam = true;
                break;
            }
        }

        if ($isSpam) {
            // Langsung hapus/abaikan komentar jika mengandung kata kotor
            // Secara UX, berikan notifikasi sukses agar bot/spammer tidak tahu, tapi tidak disimpan.
            // Atau berikan notifikasi gagal. Kita tolak secara halus.
            return back()->with('error', 'Komentar Anda gagal dikirim karena mengandung kata-kata yang tidak pantas.');
        }

        // Simpan komentar
        Komentar::create([
            'berita_id' => $berita->id,
            'nama' => strip_tags($request->nama),
            'email' => strip_tags($request->email),
            'no_hp' => strip_tags($request->no_hp),
            'isi' => strip_tags($request->isi),
            'status' => 'pending'
        ]);

        // Hapus session captcha setelah berhasil digunakan
        session()->forget('komentar_captcha');

        return back()->with('success', 'Terima kasih! Komentar Anda berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function reloadCaptcha()
    {
        // Generate captcha random string
        $captcha = strtoupper(Str::random(5));
        session(['komentar_captcha' => $captcha]);
        
        // Buat string HTML dengan spasi agar lebih jelas
        $captchaSpaced = implode(' ', str_split($captcha));
        
        return response()->json(['captcha' => $captchaSpaced]);
    }
}
