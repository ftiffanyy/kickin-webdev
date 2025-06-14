<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'date',
        'total_price',
        'total_qty',
        'status',
        'shipping_address',
        'shipping_status',
        'invoice_number',
        'payment_url',
        'user_id',
    ];
    
    // User dan Order (1 to many)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Order dan OrderDetail (1 to many)
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Order dan Shipping (1 to many)
    public function shippings(): HasMany
    {
        return $this->hasMany(Shipping::class, 'order_id');
    }

    // Relasi Order ke Review (One to Many)
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id');
    }
}
