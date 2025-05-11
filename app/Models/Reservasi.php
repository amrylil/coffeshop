<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table      = 'reservasi_222297';
    protected $primaryKey = 'kode_reservasi_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at_222297';
    const UPDATED_AT = 'updated_at_222297';

    protected $fillable = [
        'kode_reservasi_222297',
        'nama_pelanggan_222297',
        'no_telepon_222297',
        'tanggal_reservasi_222297',
        'jam_reservasi_222297',
        'jumlah_orang_222297',
        'nomor_meja_222297',
        'catatan_222297',
    ];

    protected $casts = [
        'tanggal_reservasi_222297' => 'date',
        'jam_reservasi_222297'     => 'datetime',
        'created_at_222297'        => 'datetime',
        'updated_at_222297'        => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_reservasi_222297) {
                $model->kode_reservasi_222297 = IDGeneratorHelper::generateReservasiID();
            }
        });
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'nomor_meja_222297', 'nomor_meja_222297');
    }
}
