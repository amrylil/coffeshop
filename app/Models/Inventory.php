<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'kode_bahan';
    protected $table      = 'inventory';

    public $incrementing = false;
    protected $keyType   = 'string';

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'satuan',
        'stok',
    ];

    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            'menu_bahan',
            'kode_bahan',
            'kode_menu'
        )->withPivot('jumlah');
    }
}