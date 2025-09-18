<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuBahan extends Model
{
    protected $table = 'menu_bahan';

    protected $fillable = [
        'kode_menu',
        'kode_bahan',
        'jumlah',
    ];
}