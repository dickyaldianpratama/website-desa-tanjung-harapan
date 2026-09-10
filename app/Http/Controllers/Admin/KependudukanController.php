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
            'running_text_kependudukan'
        ];
        
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        
        return view('admin.kependudukan.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'penduduk_total', 'penduduk_laki', 'penduduk_perempuan',
            'running_text_kependudukan'
        ];

        foreach ($keys as $key) {
            $val = $request->input($key, ''); // default empty string
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $val]);
            } else {
                // To avoid PostgreSQL sequence errors on insert:
                $maxId = Setting::max('id');
                Setting::insert([
                    'id' => $maxId ? $maxId + 1 : 1,
                    'key' => $key,
                    'value' => $val,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.kependudukan.index')->with('success', 'Data kependudukan berhasil diperbarui.');
    }
}
