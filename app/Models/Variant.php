<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variant extends Model
{
    // Product dan Variant (1 to many)
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Variant dan OrderDetail (1 to many)
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'variant_id');
    }

    // Variant dan CartItem (1 to many)
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class, 'variant_id');
    }

}
