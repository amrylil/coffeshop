<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    use HasFactory;

    protected $table      = 'item_keranjang_222297';
    protected $primaryKey = 'kode_item_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at_222297';
    const UPDATED_AT = 'updated_at_222297';

    protected $fillable = [
        'kode_item_222297',
        'kode_keranjang_222297',
        'kode_menu_222297',
        'quantity_222297',
        'price_222297',
    ];

    protected $casts = [
        'price_222297'      => 'decimal:2',
        'created_at_222297' => 'datetime',
        'updated_at_222297' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_item_222297) {
                $model->kode_item_222297 = IDGeneratorHelper::generateItemKeranjangID();
            }
        });
    }

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'kode_keranjang_222297', 'kode_keranjang_222297');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu_222297', 'kode_menu_222297');
    }
}
