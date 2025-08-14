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
        'user_id',
        'kode_reservasi',
        'tanggal_reservasi',
        'jam_reservasi',
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
            if (! $model->kode_reservasi) {
                $model->kode_reservasi = IDGeneratorHelper::generateReservasiID();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'nomor_meja', 'nomor_meja');
    }
}