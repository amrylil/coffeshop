<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table      = 'transaksi';
    protected $primaryKey = 'kode_transaksi';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'kode_transaksi',
        'email',
        'kode_menu',
        'jenis_pesanan',
        'jumlah',
        'harga_total',
        'status',
        'bukti_tf',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'harga_total'       => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_transaksi) {
                $model->kode_transaksi = IDGeneratorHelper::generateTransaksiID();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'kode_transaksi', 'kode_transaksi');
    }
}
