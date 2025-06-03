<?php

namespace App\Http\Controllers;


use id;
use App\Models\Order;
use App\Models\Review;
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


    // public function orderdetails($id)
    // {
    //     $order = Order::with([
    //         'orderDetails.variant.product.images',
    //         'shippings'
    //     ])->findOrFail($id);

    //     // Pastikan order milik user login
    //     if ($order->user_id !== session('user_id')) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     return view('cust.orderdetails', compact('order'));
    // }

    public function orderdetails($id)
    {
        $userId = session('user_id');

        $order = Order::with([
            'orderDetails.variant.product.images',
            'shippings'
        ])->findOrFail($id);

        if ($order->user_id !== $userId) {
            abort(403, 'Unauthorized access');
        }

        // Ambil product_id dari order details
        $productIds = $order->orderDetails->pluck('variant.product.id')->toArray();

        // Ambil review user untuk order ini dan produk terkait
        $userReviews = Review::where('order_id', $order->id)
            ->where('user_id', $userId)
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id'); // agar gampang cek apakah sudah review atau belum per produk

        return view('cust.orderdetails', compact('order', 'userReviews'));
    }

    public function submitReview(Request $request, $order_id, $product_id)
    {
        $userId = session('user_id'); 

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Cek apakah order milik user dan produk ada di order tersebut
        $order = Order::with('orderDetails.variant.product')->findOrFail($order_id);

        if ($order->user_id != $userId) {
            abort(403);
        }

        $productIds = $order->orderDetails->pluck('variant.product.id')->toArray();
        if (!in_array($product_id, $productIds)) {
            abort(403);
        }

        // Cek apakah user sudah review produk ini di order ini
        $review = Review::where('order_id', $order_id)
            ->where('user_id', $userId)
            ->where('product_id', $product_id)
            ->first();

        if ($review) {
            // Update rating jika sudah ada
            $review->rating = $request->rating;
            $review->save();
        } else {
            // Buat review baru
            Review::create([
                'rating' => $request->rating,
                'date' => now(),
                'user_id' => $userId,
                'order_id' => $order_id,
                'product_id' => $product_id,
            ]);
        }

        return back()->with('success', 'Review berhasil disimpan.');
    }

}


