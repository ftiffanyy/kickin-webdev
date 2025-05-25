<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ Pakai primary key baru
    protected $primaryKey = 'user_id';

    // ✅ Jika kamu rename password menjadi user_password, sesuaikan di bawah
    protected $fillable = [
        'user_name',
        'user_email',
        'user_password',
        'user_phone',
        'user_role',
    ];

    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    // ✅ Perlu override password default untuk login
    public function getAuthPassword()
    {
        return $this->user_password;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // ✅ Jika primary key bukan "id"
    public $incrementing = true;
    public $timestamps = true;

    // ✅ Jika primary key bukan integer (tidak perlu ubah ini jika tetap integer)
    // protected $keyType = 'int';
}
