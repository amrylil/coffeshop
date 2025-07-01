<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table      = 'keranjang';
    protected $primaryKey = 'kode_keranjang';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'kode_keranjang',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_keranjang) {
                $model->kode_keranjang = IDGeneratorHelper::generateKeranjangID();
            }
        });
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function items()
    {
        return $this->hasMany(ItemKeranjang::class, 'kode_keranjang', 'kode_keranjang');
    }
}
