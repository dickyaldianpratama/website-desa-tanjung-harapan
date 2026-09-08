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

    public function generateCaptchaImage()
    {
        $string = strtoupper(Str::random(5));
        session(['komentar_captcha' => $string]);

        $width = 160;
        $height = 50;

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$width.'" height="'.$height.'">';
        $svg .= '<rect width="100%" height="100%" fill="#f1f5f9" />';

        // Garis acak (noise)
        for ($i = 0; $i < 5; $i++) {
            $x1 = rand(0, $width); $y1 = rand(0, $height);
            $x2 = rand(0, $width); $y2 = rand(0, $height);
            $color = sprintf('#%06X', mt_rand(0x888888, 0xCCCCCC));
            $svg .= '<line x1="'.$x1.'" y1="'.$y1.'" x2="'.$x2.'" y2="'.$y2.'" stroke="'.$color.'" stroke-width="'.rand(1,3).'" />';
        }

        // Kurva acak
        for ($i = 0; $i < 3; $i++) {
            $path = "M".rand(0, $width)." ".rand(0, $height)." Q".rand(0, $width)." ".rand(0, $height)." ".rand(0, $width)." ".rand(0, $height);
            $color = sprintf('#%06X', mt_rand(0x999999, 0xDDDDDD));
            $svg .= '<path d="'.$path.'" fill="none" stroke="'.$color.'" stroke-width="2" />';
        }

        // Teks Captcha
        $colors = ['#d93838', '#1e40af', '#047857', '#b45309', '#6d28d9', '#1f2937'];
        $fonts = ['Arial', 'Verdana', 'Courier New', 'Georgia', 'Trebuchet MS'];
        
        $x = 20;
        for ($i = 0; $i < strlen($string); $i++) {
            $color = $colors[array_rand($colors)];
            $font = $fonts[array_rand($fonts)];
            $y = rand(30, 40);
            $rotate = rand(-25, 25);
            $fontSize = rand(26, 34);
            $weight = rand(0, 1) ? 'bold' : 'normal';
            
            $svg .= '<text x="'.$x.'" y="'.$y.'" font-family="'.$font.'" font-size="'.$fontSize.'" font-weight="'.$weight.'" fill="'.$color.'" transform="rotate('.$rotate.' '.$x.' '.$y.')">'.$string[$i].'</text>';
            $x += rand(22, 28);
        }

        $svg .= '</svg>';

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }
}
