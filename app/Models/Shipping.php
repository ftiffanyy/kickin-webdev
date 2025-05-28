<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipping extends Model
{
    protected $table = 'shippings';  // nama tabel jika tidak plural dari model

    protected $fillable = [
        'status',
        'date',
        'comment',
        'order_id',
    ];

    // Relasi ke Order (many-to-1)
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
