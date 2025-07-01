<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table      = 'reservasi';
    protected $primaryKey = 'kode_reservasi';
    public $incrementing  = false;
    protected $keyType    = 'string';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'email',
        'kode_reservasi',
        'nama_pelanggan',
        'no_telepon',
        'tanggal_reservasi',
        'jam_reservasi',
        'jumlah_orang',
        'nomor_meja',
        'catatan',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'jam_reservasi'     => 'datetime',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->kode_reservasi) {
                $model->kode_reservasi = IDGeneratorHelper::generateReservasiID();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(Meja::class, 'email', 'email');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'nomor_meja', 'nomor_meja');
    }
}
