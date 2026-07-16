<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Berita extends Model {
    protected $fillable = ['judul','slug','isi','gambar','kategori','status','published_at','views'];
    protected $casts = ['published_at' => 'datetime'];
    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) $model->slug = Str::slug($model->judul);
        });
    }
    public function scopePublish($query) { return $query->where('status', 'publish'); }
    public function getRouteKeyName() { return 'slug'; }
}
