<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orderadmin()
    {
        $orders = Order::get();  // pastikan relasi 'user' sudah dibuat
        return view('admin.orderpage', compact('orders'));
    }

    public function orderdadmin($orderid)
    {
        $order = Order::with(['user', 'orderDetails.variant.product'])->findOrFail($orderid);
        return view('admin.detailspage', compact('order'));
    }
}



// halo ini valen tes ke 2
// halo ini valen tes ke 3