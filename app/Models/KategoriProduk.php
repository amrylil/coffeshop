<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table      = 'kategori_produk_222297';
    protected $primaryKey = 'kode_kategori_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'kode_kategori_222297',
        'nama_222297',
        'deskripsi_222297',
        'path_img_222297',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (!$model->kode_kategori_222297) {
    //             $model->kode_kategori_222297 = IDGeneratorHelper::generateKategoriID();
    //         }
    //     });
    // }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kode_kategori_222297', 'kode_kategori_222297');
    }
}
