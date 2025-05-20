<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table      = 'transaksi_222297';
    protected $primaryKey = 'kode_transaksi_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at_222297';
    const UPDATED_AT = 'updated_at_222297';

    protected $fillable = [
        'kode_transaksi_222297',
        'email_222297',
        'kode_menu_222297',
        'jumlah_222297',
        'harga_total_222297',
        'status_222297',
        'bukti_tf_222297',
        'tanggal_transaksi_222297',
    ];

    protected $casts = [
        'harga_total_222297'       => 'decimal:2',
        'tanggal_transaksi_222297' => 'datetime',
        'created_at_222297'        => 'datetime',
        'updated_at_222297'        => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_transaksi_222297) {
                $model->kode_transaksi_222297 = IDGeneratorHelper::generateTransaksiID();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email_222297', 'email_222297');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'kode_menu_222297', 'kode_menu_222297');
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class, 'kode_transaksi_222297', 'kode_transaksi_222297');
    }
}
