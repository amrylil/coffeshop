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

    protected $table      = 'users';
    protected $primaryKey = 'email';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'password',
        'gender',
        'role',
        'address',
        'phone',
        'birth_date',
        'profile_photo',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifierName()
    {
        return 'email';
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
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'email', 'email');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'email', 'email');
    }
}
