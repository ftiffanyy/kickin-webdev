<?php

namespace App\Http\Controllers;

use id;
use Exception;
use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use App\Models\CartItem;
use App\Models\Wishlist;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function show()
    {
        $userId = session('user_id'); // Cek user_id yang ada di session

        // Ambil semua produk
        $products = Product::with('images')->get();

        // Ambil daftar brand unik
        $brands = Product::distinct()->pluck('brand');

        // Ambil daftar ukuran unik dari variant
        $sizes = Variant::distinct()->pluck('size');

        // Cek apakah user login atau tidak
        if ($userId) {
            // Jika login, ambil daftar produk yang ada di wishlist user
            $userWishlistProductIds = Wishlist::where('user_id', $userId)
                ->pluck('product_id'); // hanya ambil product_id saja
        } else {
            // Jika tidak login, wishlist-nya kosong
            $userWishlistProductIds = collect(); // Wishlist kosong
        }

        // Return view dengan data produk, brand, ukuran, dan wishlist
        return view('cust.product', compact('products', 'brands', 'sizes', 'userWishlistProductIds'));   
    }


    public function showDetail($id)
    {
        // Fetch the product by ID
        $products = Product::findOrFail($id);

        // Fetch the variants (sizes and stock) for the product
        $availableSizes = $products->variants->pluck('stock', 'size'); // Plucking stock and size

        // Fetch all images for the product
        $images = $products->images()->get(); // Get all images

        // Return the product details view with the data
        return view('cust.details', compact('products', 'images', 'availableSizes'));
    }

    public function cart()
    {
        // Mengambil user_id dari session, pastikan user sudah login
        $userId = session('user_id');  // Mengambil ID pengguna yang sedang login
        
        // Mengambil data cart dari database berdasarkan user_id
        $cart = CartItem::with('variant')  // Menambahkan relasi dengan varian (produk)
            ->where('user_id', $userId)
            ->get();

        // Return the view with the cart data
        return view('cust.cart', compact('cart'));
    }

    public function addToCart(Request $request, $productId)
    {
        // Validasi input untuk quantity dan size
        $request->validate([
            'size' => 'required|exists:variants,size,product_id,' . $productId,
            'qty' => 'required|integer|min:1'
        ]);

        $userId = session('user_id'); // Pastikan user sudah login
        $size = $request->size;
        $qty = (int) $request->qty;

        // Cari variant berdasarkan product_id dan size
        $variant = Variant::where('product_id', $productId)
                        ->where('size', $size)
                        ->firstOrFail();

        // Cek tombol yang ditekan: add_to_cart atau buy_now
        if ($request->input('action') === 'buy_now') {
            session(['buy_now_item' => [
            'variant_id' => $variant->id,
            'qty' => $qty,
            ]]);

            // Redirect ke route copage (checkout page)
            return redirect()->route('copage');
        }

        // Kalau tombol Add to Cart:
        // Cek apakah item sudah ada di cart
        $existingCartItem = CartItem::where('user_id', $userId)
                                    ->where('variant_id', $variant->id)
                                    ->first();

        if ($existingCartItem) {
            // Update qty
            $existingCartItem->qty += $qty;
            $existingCartItem->save();
        } else {
            // Buat item baru
            CartItem::create([
                'qty' => $qty,
                'user_id' => $userId,
                'variant_id' => $variant->id,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }




    // Controller method updateCart

    public function updateCart(Request $request)
    {
        $userId = session('user_id');

        // Jika request AJAX untuk update quantity
        if ($request->ajax() && $request->has('id') && $request->has('quantity')) {
            $cartItemId = $request->input('id');
            $newQuantity = max(1, (int) $request->input('quantity'));

            $cartItem = CartItem::where('user_id', $userId)
                ->where('id', $cartItemId)
                ->first();

            if ($cartItem) {
                $cartItem->qty = $newQuantity; // Gunakan 'qty' bukan 'cart_qty'
                $cartItem->save();

                // Hitung ulang total
                $cart = CartItem::where('user_id', $userId)->get();
                $newTotal = $cart->sum(function ($item) {
                    return $item->variant->product->price * (1 - $item->variant->product->product_discount / 100) * $item->qty;
                });

                return response()->json([
                    'success' => true,
                    'new_total' => number_format($newTotal, 0, ',', '.'),
                    'item_total' => number_format($cartItem->variant->product->price * (1 - $cartItem->variant->product->product_discount / 100) * $cartItem->qty, 0, ',', '.')
                ]);
            }

            return response()->json(['success' => false]);
        }

        // Handle form submission untuk bulk update/delete dan checkout
        $action = $request->input('action'); // 'remove' atau 'checkout'
        $quantities = $request->input('quantity', []);
        $selectedItems = $request->input('selected_items', []);

        // Update quantities dulu
        foreach ($quantities as $cartItemId => $newQuantity) {
            $newQuantity = max(1, (int) $newQuantity);
            $cartItem = CartItem::where('user_id', $userId)
                ->where('id', $cartItemId)
                ->first();

            if ($cartItem) {
                $cartItem->qty = $newQuantity;
                $cartItem->save();
            }
        }

        if ($action === 'remove') {
            // Delete selected items
            foreach ($selectedItems as $cartItemId) {
                $cartItem = CartItem::where('user_id', $userId)
                    ->where('id', $cartItemId)
                    ->first();

                if ($cartItem) {
                    $cartItem->delete();
                }
            }
            return redirect()->back()->with('success', 'Cart Updated Successfully!');
        } 
        elseif ($action === 'checkout') 
        {
            // Redirect atau proses checkout dengan selectedItems
            if (empty($selectedItems)) {
                return redirect()->back()->with('error', 'Please select at least one item to checkout.');
            }
            // Simpan selectedItems di session atau proses sesuai logika checkout kamu
            session(['checkout_items' => $selectedItems]);

            return redirect()->route('copage'); // Arahkan ke halaman checkout
        }

        return redirect()->back()->with('success', 'Cart Updated Successfully!');
    }

    public function copage(Request $request)
    {
        $userId = session('user_id');

        // Cek dulu ada buy_now_item di session gak
        $buyNowItem = session('buy_now_item');

        if ($buyNowItem) {
            // Jika ada, ambil variant dan buat collection agar view bisa render sama seperti cartItems
            $variant = Variant::with('product.images')->findOrFail($buyNowItem['variant_id']);

            $cartItems = collect([
                (object)[
                    'id' => 0, // dummy id
                    'variant' => $variant,
                    'qty' => $buyNowItem['qty'],
                    'variant_id' => $variant->id,
                    'price_at_purchase' => $variant->product->price * (1 - ($variant->product->discount ?? 0) / 100),
                ]
            ]);

            return view('cust.copage', compact('cartItems'));
        }

        // Kalau gak ada buy_now_item, ambil dari cart berdasarkan session checkout_items
        $checkoutItems = session('checkout_items', []);

        $cartItems = CartItem::with('variant.product.images')
            ->where('user_id', $userId)
            ->whereIn('id', $checkoutItems)
            ->get();

        return view('cust.copage', compact('cartItems'));
    }


    public function checkout(Request $request)
    {
        $userId = session('user_id');
        $checkoutItems = session('checkout_items', []);

        // Jika checkout_items kosong, cek data buy now dari request
        if (empty($checkoutItems)) {
            $buyNowItem = session('buy_now_item');
            $variant = Variant::with('product.images')->findOrFail($buyNowItem['variant_id']);

            // Buat koleksi dummy cartItems dari data buy now
            $cartItems = collect([
                (object)[
                    'id' => 0, // dummy id supaya uniform
                    'variant' => $variant,
                    'qty' => $buyNowItem['qty'],
                    'variant_id' => $variant->id,
                ]
            ]);
            session()->forget('buy_now_item');

        } else {
            // Checkout dari cart biasa
            $cartItems = CartItem::with('variant.product')
                ->where('user_id', $userId)
                ->whereIn('id', $checkoutItems)
                ->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Item checkout tidak ditemukan.');
            }
        }

        // Validasi delivery & alamat
        $request->validate([
            'delivery' => 'required|in:Pick Up,Shipping',
            'address' => 'required_if:delivery,Shipping|max:65535',
            'pickup_location' => 'required_if:delivery,Pick Up|string|max:65535',
        ]);

        // Hitung total qty dan harga
        $totalQty = 0;
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
            $price = $item->variant->product->price * (1 - $discount / 100);
            $totalPrice += $price * $item->qty;
            $totalQty += $item->qty;
        }

        // Ongkos kirim
        $shippingCost = ($request->delivery == 'Shipping') ? 20000 : 0;
        $totalPrice += $shippingCost;

        $invoiceNumber = strtoupper(Str::random(10));

        DB::beginTransaction();

        try {
            $shippingAddress = ($request->delivery == 'Shipping') ? $request->address : $request->pickup_location;

            $order = Order::create([
                'date' => now(),
                'total_price' => $totalPrice,
                'total_qty' => $totalQty,
                'status' => $request->delivery,
                'shipping_address' => $shippingAddress,
                'shipping_status' => 'Pending',
                'invoice_number' => $invoiceNumber,
                'payment_url' => "la",
                'user_id' => $userId,
            ]);

            // Simpan order details
            foreach ($cartItems as $item) {
                $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
                $priceAtPurchase = $item->variant->product->price * (1 - $discount / 100);

                $variant = Variant::find($item->variant_id);

                if ($variant) {
                    // Kurangi stok dengan kuantitas yang dibeli
                    $variant->stock -= $item->qty;
                    
                    // Simpan perubahan stok
                    $variant->save();
                }
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'variant_id' => $item->variant_id,
                    'qty' => $item->qty,
                    'price_at_purchase' => $priceAtPurchase,
                ]);
            }

            // Midtrans Config
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $user = User::find($userId);

            $params = [
                'transaction_details' => [
                    'order_id' => $invoiceNumber,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user ? $user->name : 'Guest',
                    'email' => $user ? $user->email : 'guest@example.com',
                ],
                'callback' => [
                    'finish' => route('order_customer'),
                ],
            ];
            
            $snapUrl = Snap::createTransaction($params)->redirect_url;
            $order->payment_url = $snapUrl;
            $order->save();

            // Kalau checkout dari cart, hapus item dari cart dan session
            if (!empty($checkoutItems)) {
                CartItem::where('user_id', $userId)->whereIn('id', $checkoutItems)->delete();
                session()->forget('checkout_items');
            }
            
            DB::commit();

            return redirect($snapUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses checkout: ' . $e->getMessage());
        }
    }


    // Tambahkan method ini di ProductController Anda
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $query = Product::with('images')
            ->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%');
            });
        
        $products = $query->get()
            ->map(function($product) {
                // Calculate reviews from table
                $reviewsFromTable = Review::where('product_id', $product->id);
                $newReviewsCount = $reviewsFromTable->count();
                $newReviewsAvg = $reviewsFromTable->avg('rating') ?? 0;
                
                // Existing data from product
                $existingReviewsCount = $product->total_reviews;
                $existingRatingAvg = $product->rating_avg;
                
                // Calculate weighted average
                if ($newReviewsCount > 0) {
                    $totalRatingPoints = ($existingRatingAvg * $existingReviewsCount) + ($newReviewsAvg * $newReviewsCount);
                    $totalReviewsCount = $existingReviewsCount + $newReviewsCount;
                    $finalRating = round($totalRatingPoints / $totalReviewsCount, 2);
                } else {
                    $finalRating = $existingRatingAvg;
                }
                
                // Calculate total reviews
                $reviewsCount = Review::where('product_id', $product->id)->count();
                $totalReviews = $product->total_reviews + $reviewsCount;
                
                // Calculate total sold
                $soldFromOrders = DB::table('order_details')
                    ->join('variants', 'order_details.variant_id', '=', 'variants.id')
                    ->where('variants.product_id', $product->id)
                    ->sum('order_details.qty');
                $totalSold = $product->sold + $soldFromOrders;
                
                // Add calculated fields to product
                $product->final_rating = $finalRating;
                $product->total_reviews_count = $totalReviews;
                $product->total_sold_count = $totalSold;
                $product->image_url = $product->images->isNotEmpty() ? 
                    asset('images/' . $product->images->first()->url) : null;
                
                return $product;
            });
        
        return view('admin.productadmin', compact('products'));
    }



}
