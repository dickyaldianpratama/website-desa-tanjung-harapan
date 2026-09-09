<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KependudukanController extends Controller
{
    public function show($kategori = 'wilayah')
    {
        $validKategori = ['wilayah', 'agama', 'pekerjaan', 'pendidikan', 'umur', 'perkawinan'];
        
        if (!in_array($kategori, $validKategori)) {
            abort(404);
        }

        // Data Google Sheets Links (Hardcoded as requested)
        $sheets = [
            'Dusun 1' => 'https://docs.google.com/spreadsheets/d/1QEhKsH3GG-UANc32xkpfGXYhulNvAVnHxu8uY66r7EU/htmlembed?widget=true&headers=false',
            'Dusun 2' => 'https://docs.google.com/spreadsheets/d/1mDNg53Xk2n0yIQ2y7cNwKHsciC4-klgyEAUGkpC8a4o/htmlembed?widget=true&headers=false',
            'Dusun 3' => 'https://docs.google.com/spreadsheets/d/1MljmMpCDAKDo-LQBuEDSGDkFDkh2x8DEFkxCr3v2olw/htmlembed?widget=true&headers=false',
            'Dusun 4' => 'https://docs.google.com/spreadsheets/d/1YNNKrbbEVE77nkuERs06RJ-wcC8t2lR4tOBryoaI1PU/htmlembed?widget=true&headers=false',
        ];

        return view('pages.kependudukan.show', compact('kategori', 'sheets'));
    }
}
