<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table      = 'menu_222297';
    protected $primaryKey = 'kode_menu_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at_222297';
    const UPDATED_AT = null;

    protected $fillable = [
        'kode_menu_222297',
        'nama_222297',
        'deskripsi_222297',
        'harga_222297',
        'kode_kategori_222297',
        'path_img_222297',
        'jumlah_222297',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_menu_222297) {
                $model->kode_menu_222297 = IDGeneratorHelper::generateMenuID();
            }
        });
    }

    protected $casts = [
        'harga_222297'      => 'decimal:2',
        'created_at_222297' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kode_kategori_222297', 'kode_kategori_222297');
    }

    public function itemKeranjang()
    {
        return $this->hasMany(ItemKeranjang::class, 'kode_menu_222297', 'kode_menu_222297');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kode_menu_222297', 'kode_menu_222297');
    }
}
