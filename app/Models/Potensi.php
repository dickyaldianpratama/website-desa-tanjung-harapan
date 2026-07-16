<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Potensi extends Model {
    protected $fillable = ['judul','slug','deskripsi','gambar','kategori'];
    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) $model->slug = Str::slug($model->judul);
        });
    }
    public function getRouteKeyName() { return 'slug'; }
}
