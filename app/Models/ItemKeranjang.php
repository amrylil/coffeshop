<?php
namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemKeranjang extends Model
{
    use HasFactory;

    // Properti yang sudah Anda miliki (benar)
    protected $table      = 'item_keranjang';
    protected $primaryKey = 'kode_item';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'kode_item',
        'kode_keranjang',
        'kode_menu',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // --- TAMBAHAN 1: Daftarkan Accessor ---
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['line_total'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->kode_item) {
                $model->kode_item = IDGeneratorHelper::generateItemKeranjangID();
            }
        });
    }

    // Relasi yang sudah Anda miliki (benar)
    public function keranjang(): BelongsTo
    {
        return $this->belongsTo(Keranjang::class, 'kode_keranjang', 'kode_keranjang');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'kode_menu', 'kode_menu');
    }

    // --- TAMBAHAN 2: Fungsi Accessor ---
    /**
     * Get the total price for the cart item line.
     *
     * @return float
     */
    public function getLineTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}