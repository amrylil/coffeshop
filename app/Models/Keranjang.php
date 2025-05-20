<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table      = 'keranjang_222297';
    protected $primaryKey = 'kode_keranjang_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at_222297';
    const UPDATED_AT = 'updated_at_222297';

    protected $fillable = [
        'kode_keranjang_222297',
        'email_222297',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_keranjang_222297) {
                $model->kode_keranjang_222297 = IDGeneratorHelper::generateKeranjangID();
            }
        });
    }

    protected $casts = [
        'created_at_222297' => 'datetime',
        'updated_at_222297' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email_222297', 'email_222297');
    }

    public function items()
    {
        return $this->hasMany(ItemKeranjang::class, 'kode_keranjang_222297', 'kode_keranjang_222297');
    }
}
