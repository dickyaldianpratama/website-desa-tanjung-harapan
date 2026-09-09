<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class StatistikController extends Controller
{
    public function show($jenis = 'wilayah')
    {
        $settings = Setting::all()->pluck('value', 'key');
        
        $validJenis = ['agama', 'pekerjaan', 'pendidikan', 'umur', 'perkawinan', 'wilayah', 'keluarga'];
        if (!in_array($jenis, $validJenis)) {
            $jenis = 'wilayah';
        }

        return view('pages.statistik', compact('jenis', 'settings'));
    }
}
