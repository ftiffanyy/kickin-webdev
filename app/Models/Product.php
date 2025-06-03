<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'discount', 'brand', 'gender', 'description',
    ];

    // Product dan Image (1 to many)
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id');
    }

    // Product dan Variant (1 to many)
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id');
    }

    // Product dan Review (1 to many)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    // Product dan Wishlist (1 to many)
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    /**
 * Get the users who have this product in their wishlist.
 */
public function wishlistedBy()
{
    return $this->belongsToMany(User::class, 'wishlists');
}

/**
 * Check if this product is in a specific user's wishlist
 */
public function isInWishlistOf($userId)
{
    return $this->wishlists()->where('user_id', $userId)->exists();
}

/**
 * Get the total number of users who have this product in their wishlist
 */
public function getWishlistCountAttribute()
{
    return $this->wishlists()->count();
}

/**
 * Scope to get products that are in a specific user's wishlist
 */
public function scopeInWishlistOf($query, $userId)
{
    return $query->whereHas('wishlists', function($q) use ($userId) {
        $q->where('user_id', $userId);
    });
}

/**
 * Scope to get products with wishlist count
 */
public function scopeWithWishlistCount($query)
{
    return $query->withCount('wishlists');
}

}
