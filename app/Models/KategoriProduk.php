<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    use HasFactory;

    protected $table      = 'kategori_produk';
    protected $primaryKey = 'kode_kategori';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'kode_kategori',
        'nama',
        'deskripsi',
        'path_img',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         if (!$model->kode_kategori) {
    //             $model->kode_kategori = IDGeneratorHelper::generateKategoriID();
    //         }
    //     });
    // }

    public function menu()
    {
        return $this->hasMany(Menu::class, 'kode_kategori', 'kode_kategori');
    }
}
