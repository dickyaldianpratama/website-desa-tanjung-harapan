<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Perangkat extends Model {
    protected $fillable = ['nama','jabatan','foto','nip','urutan'];
    public function scopeUrut($query) { return $query->orderBy('urutan'); }
}
