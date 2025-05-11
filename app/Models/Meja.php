<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table      = 'meja_222297';
    protected $primaryKey = 'nomor_meja_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'nomor_meja_222297',
        'kapasitas_222297',
        'status_222297',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->nomor_meja_222297) {
                $model->nomor_meja_222297 = IDGeneratorHelper::generateMejaID();
            }
        });
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'nomor_meja_222297', 'nomor_meja_222297');
    }
}
