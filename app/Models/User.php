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

/**
 * Get the products in user's wishlist.
 */
public function wishlistProducts()
{
    return $this->belongsToMany(Product::class, 'wishlists');
}

/**
 * Check if user has a product in wishlist
 */
public function hasInWishlist($productId)
{
    return $this->wishlists()->where('product_id', $productId)->exists();
}

/**
 * Add product to user's wishlist
 */
public function addToWishlist($productId)
{
    if (!$this->hasInWishlist($productId)) {
        return $this->wishlists()->create(['product_id' => $productId]);
    }
    return false;
}

/**
 * Remove product from user's wishlist
 */
public function removeFromWishlist($productId)
{
    return $this->wishlists()->where('product_id', $productId)->delete();
}

/**
 * Toggle product in user's wishlist
 */
public function toggleWishlist($productId)
{
    if ($this->hasInWishlist($productId)) {
        $this->removeFromWishlist($productId);
        return 'removed';
    } else {
        $this->addToWishlist($productId);
        return 'added';
    }
}

/**
 * Get user's wishlist count
 */
public function getWishlistCountAttribute()
{
    return $this->wishlists()->count();
}

}
