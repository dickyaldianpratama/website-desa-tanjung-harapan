<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tiket',
        'nomor_surat',
        'jenis_layanan',
        'nik',
        'nama_lengkap',
        'no_whatsapp',
        'keperluan',
        'file_lampiran',
        'status',
        'catatan_admin',
    ];

    public static function generateTiket()
    {
        $prefix = 'SRT-' . date('Ym') . '-';
        $last = self::where('nomor_tiket', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        if ($last) {
            $number = intval(substr($last->nomor_tiket, -3)) + 1;
        } else {
            $number = 1;
        }
        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
