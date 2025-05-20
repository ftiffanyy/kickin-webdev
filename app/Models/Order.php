<?php

namespace App\Models;

class Order
{
    public $invoice_number;
    public $user_id;
    public $customer_name;
    public $total_price;
    public $status;
    public $payment_url;
    public $items = [];

    public function __construct(array $data)
    {
        $this->invoice_number = $data['invoice_number'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->customer_name = $data['customer_name'] ?? null;
        $this->total_price = $data['total_price'] ?? 0;
        $this->status = $data['status'] ?? 'pending';
        $this->payment_url = $data['payment_url'] ?? null;
        $this->items = $data['items'] ?? [];
    }
}
