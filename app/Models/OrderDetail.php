<?php

namespace App\Models;

class OrderDetail
{
    public $product_id;
    public $product_name;
    public $quantity;
    public $price;
    public $subtotal;

    public function __construct(array $data)
    {
        $this->product_id = $data['product_id'] ?? null;
        $this->product_name = $data['product_name'] ?? null;
        $this->quantity = $data['quantity'] ?? 1;
        $this->price = $data['price'] ?? 0;
        $this->subtotal = $this->price * $this->quantity;
    }
}
