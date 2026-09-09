<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class KependudukanController extends Controller
{
    public function index()
    {
        $keys = [
            'penduduk_total', 'penduduk_laki', 'penduduk_perempuan',
            'link_statistik_keluarga', 'link_agama', 'link_pekerjaan',
            'link_pendidikan', 'link_umur', 'link_perkawinan', 'link_wilayah',
            'running_text_kependudukan'
        ];
        
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        
        return view('admin.kependudukan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'penduduk_total', 'penduduk_laki', 'penduduk_perempuan',
            'link_statistik_keluarga', 'link_agama', 'link_pekerjaan',
            'link_pendidikan', 'link_umur', 'link_perkawinan', 'link_wilayah',
            'running_text_kependudukan'
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()->route('admin.kependudukan.index')->with('success', 'Data kependudukan berhasil diperbarui.');
    }
}
