<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    protected $fillable = ['nama', 'jabatan', 'tipe', 'foto', 'urutan'];
    public function scopeUrut($query) { return $query->orderBy('urutan'); }
}
