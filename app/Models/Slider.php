<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Slider extends Model {
    protected $fillable = ['judul', 'subtitle', 'gambar', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
    public function scopeAktif($query) { return $query->where('aktif', true)->orderBy('urutan'); }
}
