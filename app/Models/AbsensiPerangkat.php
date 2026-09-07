<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsensiPerangkat extends Model
{
    protected $fillable = ['perangkat_id', 'tanggal', 'status', 'keterangan'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class);
    }

    public function scopeHariIni($query)
    {
        return $query->where('tanggal', today());
    }

    public function scopeByTanggal($query, $date)
    {
        return $query->where('tanggal', $date);
    }
}
