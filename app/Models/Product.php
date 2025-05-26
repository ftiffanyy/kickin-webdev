<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
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

}
