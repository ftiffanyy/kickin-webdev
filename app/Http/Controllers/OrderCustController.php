<?php

namespace App\Http\Controllers;


use App\Models\Order;
use Illuminate\Http\Request;

class OrderCustController extends Controller
{
    public function show()
    {
        $userId = session('user_id');

        $orders = Order::with(['orderDetails.variant.product.images'])
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        return view('cust.orders', compact('orders'));
    }


    public function orderdetails($id)
    {
        $order = Order::with([
            'orderDetails.variant.product.images',
            'shippings'
        ])->findOrFail($id);

        // Pastikan order milik user login
        if ($order->user_id !== session('user_id')) {
            abort(403, 'Unauthorized access');
        }

        return view('cust.orderdetails', compact('order'));
    }
}


