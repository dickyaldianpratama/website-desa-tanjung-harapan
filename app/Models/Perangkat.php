<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Perangkat extends Model {
    protected $fillable = ['nama','jabatan','foto','nip','urutan'];
    public function scopeUrut($query) { return $query->orderBy('urutan'); }
    public function absensi() { return $this->hasMany(AbsensiPerangkat::class); }
    public function absensiHariIni() {
        return $this->hasOne(AbsensiPerangkat::class)->where('tanggal', today());
    }
}
