<?php
namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table      = 'menu';
    protected $primaryKey = 'kode_menu';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'kode_menu',
        'nama',
        'deskripsi',
        'harga',
        'kode_kategori',
        'path_img',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->kode_menu) {
                $model->kode_menu = IDGeneratorHelper::generateMenuID();
            }
        });
    }

    protected $casts = [
        'harga'      => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kode_kategori', 'kode_kategori');
    }

    public function itemKeranjang()
    {
        return $this->hasMany(ItemKeranjang::class, 'kode_menu', 'kode_menu');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kode_menu', 'kode_menu');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'email', 'email');
    }
}