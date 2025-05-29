<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Jika kamu rename password menjadi user_password, sesuaikan di bawah
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Perlu override password default untuk login
    public function getAuthPassword()
    {
        return $this->password;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // User dan Review (1 to many)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // User dan Order (1 to many)
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // User dan CartItem (1 to many)
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }

    // User dan Wishlist (1 to many)
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

}
