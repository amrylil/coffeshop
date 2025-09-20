<?php
namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'kode_transaksi';
    public $incrementing  = false;
    protected $keyType    = 'string';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'order_id_midtrans',
        'total_harga',
        'jenis_pembayaran',
        'status',
        'catatan',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->kode_transaksi) {
                $model->kode_transaksi = IDGeneratorHelper::generateTransaksiID();
            }
        });
    }

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemTransaksi::class, 'transaksi_id');
    }
}