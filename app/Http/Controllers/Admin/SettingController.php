<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Pisahkan field telepon_penting (array) dari field biasa
        $data = $request->except(['_token', 'telepon_jabatan', 'telepon_nomor', 'telepon_ikon']);

        // Simpan setting biasa (key => value)
        foreach ($data as $key => $value) {
            if ($key === 'link_map' && !empty($value)) {
                // Jika user mempaste seluruh tag <iframe> atau ada atribut HTML lain, ambil URL-nya saja
                if (preg_match('/src="([^"]+)"/', $value, $matches)) {
                    $value = $matches[1];
                } elseif (preg_match('/(https:\/\/www\.google\.com\/maps\/embed\?[^\s"]+)/', $value, $matches)) {
                    $value = $matches[1];
                }
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Proses nomor telepon penting (array → JSON)
        $jabatans = $request->input('telepon_jabatan', []);
        $nomors   = $request->input('telepon_nomor', []);
        $ikons    = $request->input('telepon_ikon', []);

        $teleponPenting = [];
        foreach ($jabatans as $i => $jabatan) {
            $jabatan = trim($jabatan);
            $nomor   = trim($nomors[$i] ?? '');
            if ($jabatan !== '' || $nomor !== '') {
                $teleponPenting[] = [
                    'jabatan' => $jabatan,
                    'nomor'   => $nomor,
                    'ikon'    => $ikons[$i] ?? 'bi-telephone-fill',
                ];
            }
        }

        Setting::updateOrCreate(
            ['key' => 'telepon_penting'],
            ['value' => json_encode($teleponPenting, JSON_UNESCAPED_UNICODE)]
        );

        return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
