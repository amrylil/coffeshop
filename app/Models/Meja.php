<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table      = 'meja';
    protected $primaryKey = 'nomor_meja';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->nomor_meja) {
                $model->nomor_meja = IDGeneratorHelper::generateMejaID();
            }
        });
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'nomor_meja', 'nomor_meja');
    }
}
