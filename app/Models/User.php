<?php

namespace App\Models;

use App\Helpers\IDGeneratorHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table      = 'users_222297';
    protected $primaryKey = 'user_id_222297';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id_222297',
        'email_222297',
        'name_222297',
        'password_222297',
        'gender_222297',
        'role_222297',
        'address_222297',
        'phone_222297',
        'birth_date_222297',
        'profile_photo_222297',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->user_id_222297) {
                $model->user_id_222297 = IDGeneratorHelper::generateUserID();
            }
        });
    }

    public function getAuthPassword()
    {
        return $this->password_222297;
    }

    public function getAuthIdentifierName()
    {
        return 'user_id_222297';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_222297',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date_222297' => 'date',
        'created_at_222297' => 'datetime',
        'updated_at_222297' => 'datetime',
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id_222297', 'user_id_222297');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id_222297', 'user_id_222297');
    }
}
