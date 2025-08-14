<?php
namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemTransaksi extends Model
{
    use HasFactory;

    protected $table = 'item_transaksi';

    protected $fillable = [
        'id',
        'transaksi_id',
        'kode_menu',
        'jumlah',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = IDGeneratorHelper::generateItemTransaksiID();
            }
        });
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'kode_transaksi');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'kode_menu');
    }
}