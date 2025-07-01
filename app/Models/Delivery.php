<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table      = 'delivery';
    protected $primaryKey = 'kode_pengantaran';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    protected $fillable = [
        'kode_pengantaran',
        'kode_transaksi',
        'nama_penerima',
        'alamat_pengantaran',
        'nomor_hp',
        'jasa_kurir',
        'ongkir',
        'status_pengiriman',
        'tanggal_kirim',
    ];

    protected $casts = [
        'ongkir'        => 'decimal:2',
        'tanggal_kirim' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_pengantaran) {
                $model->kode_pengantaran = IDGeneratorHelper::generateDeliveryID();
            }
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'kode_transaksi', 'kode_transaksi');
    }
}
