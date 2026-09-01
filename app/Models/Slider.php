<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Slider extends Model {
    protected $fillable = ['judul', 'subtitle', 'gambar', 'tipe_media', 'image_position', 'image_quality', 'image_scale', 'urutan', 'aktif'];
    protected $casts = ['aktif' => 'boolean', 'image_quality' => 'integer', 'image_scale' => 'integer'];
    public function scopeAktif($query) { return $query->where('aktif', true)->orderBy('urutan'); }
}
