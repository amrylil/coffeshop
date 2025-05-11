<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table      = 'delivery_222297';
    protected $primaryKey = 'kode_pengantaran_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'kode_pengantaran_222297',
        'kode_transaksi_222297',
        'nama_penerima_222297',
        'alamat_pengantaran_222297',
        'nomor_hp_222297',
        'jasa_kurir_222297',
        'ongkir_222297',
        'status_pengiriman_222297',
        'tanggal_kirim_222297',
    ];

    protected $casts = [
        'ongkir_222297'        => 'decimal:2',
        'tanggal_kirim_222297' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_pengantaran_222297) {
                $model->kode_pengantaran_222297 = IDGeneratorHelper::generateDeliveryID();
            }
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi_222297', 'kode_transaksi_222297');
    }
}
