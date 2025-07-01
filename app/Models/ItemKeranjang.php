<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    use HasFactory;

    protected $table      = 'item_keranjang';
    protected $primaryKey = 'kode_item';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'kode_item',
        'kode_keranjang',
        'kode_menu',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_item) {
                $model->kode_item = IDGeneratorHelper::generateItemKeranjangID();
            }
        });
    }

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'kode_keranjang', 'kode_keranjang');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }
}
