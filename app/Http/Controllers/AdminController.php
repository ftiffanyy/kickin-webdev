<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orderadmin()
    {
        $orders = Order::get(); 
        return view('admin.orderpage', compact('orders'));
    }

    public function orderdadmin($orderid)
    {
        $order = Order::with(['user', 'orderDetails.variant.product.images'])->findOrFail($orderid);
        return view('admin.detailspage', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validasi input
        $request->validate([
            'shipping_status' => 'required|string',
            'comment' => 'nullable|string',
        ]);

        // Update status di orders
        $order->shipping_status = $request->shipping_status;
        $order->save();

        // Simpan comment ke tabel shippings
        if ($request->comment) {
            $order->shippings()->create([
                'status' => $request->shipping_status,
                'comment' => $request->comment,
                'date' => now(),
            ]);
        }

        return redirect()->route('orderadmin')->with('success', 'Status updated successfully.');
    }

}
