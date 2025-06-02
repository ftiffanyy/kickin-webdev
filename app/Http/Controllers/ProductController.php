<?php

namespace App\Http\Controllers;

use id;
use App\Models\Product;
use App\Models\Variant;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function show()
    {
        // Fetch all products from the database
        $products = Product::all(); // You can filter with where conditions if needed

        // Fetch unique brands from the products table
        $brands = Product::distinct()->pluck('brand'); // Fetch distinct brands

        // Fetch unique sizes from the variants table
        $sizes = Variant::distinct()->pluck('size'); // Fetch distinct sizes

        // Pass the products, brands, and sizes to the view
        return view('cust.product', compact('products', 'brands', 'sizes'));
    }


    // Helper method to get the first image from a product folder
    private function getFirstImage($productId)
    {
        $path = public_path("images/products/{$productId}");
        $files = File::allFiles($path); // Get all files in the folder

        // Return the first image's relative path (if available)
        if (count($files) > 0) {
            return asset("images/products/{$productId}/" . $files[0]->getBasename());
        }

        return null; // If no image found, return null
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
         // Validasi input untuk quantity
        $request->validate([
            'size' => 'required|exists:variants,size,product_id,' . $productId,
            'qty' => 'required|integer|min:1'
        ]);

        $userId = session('user_id'); // Pastikan user sudah login
        $size = $request->size;
        $qty = $request->qty;

        // Cari variant berdasarkan product_id dan size
        $variant = Variant::where('product_id', $productId)
                        ->where('size', $size)
                        ->firstOrFail(); // Ambil variant_id berdasarkan produk dan size yang dipilih

        // Cek apakah item sudah ada di cart
        $existingCartItem = CartItem::where('user_id', $userId)
                                    ->where('variant_id', $variant->id)
                                    ->first();

        if ($existingCartItem) {
            // Jika sudah ada, update quantity
            $existingCartItem->qty += $qty;
            $existingCartItem->save();
        } else {
            // Jika belum ada, buat cart item baru
            CartItem::create([
                'qty' => $qty,
                'user_id' => $userId,
                'variant_id' => $variant->id,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');

        dd($request->all()); // Check if the request is being received correctly
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
        $checkoutItems = session('checkout_items', []);

        $cartItems = CartItem::with('variant.product.images')
            ->where('user_id', $userId)
            ->whereIn('id', $checkoutItems)
            ->get();

        return view('cust.copage', compact('cartItems'));
    }

    public function checkout(Request $request)
    {
        return redirect()->route('order_customer')->with('success', 'Checkout Complete!');
    }

    public function filterProducts(Request $request)
    {
        // Start a query on the Product model
        $query = Product::query();

        // 1. Filter by gender if selected (case-insensitive)
        if ($request->has('gender')) {
            // Convert the selected gender values to lowercase
            $genders = array_map('strtolower', $request->input('gender'));

            // Apply case-insensitive filtering using the LOWER() function
            $query->whereIn(DB::raw('LOWER(gender)'), $genders);
        }

        // 2. Filter by color (case-insensitive, based on product name)
        if ($request->has('color')) {
            $colors = $request->input('color');
            foreach ($colors as $color) {
                $query->orWhere('name', 'like', '%' . $color . '%');  // Case-insensitive check
            }
        }

        // 3. Filter by size (related to variants table)
        if ($request->has('size')) {
            $sizes = $request->input('size');
            $query->whereHas('variants', function ($variantQuery) use ($sizes) {
                // Filter by size and stock greater than 0
                $variantQuery->whereIn('size', $sizes)
                            ->where('stock', '>', 0); // Ensure stock is greater than 0
            });
        }
        // 4. Filter by brand (case-insensitive)
        if ($request->has('brand')) {
            $brands = $request->input('brand');
            $query->whereIn('brand', $brands);
        }

        // 5. Sort by price if selected
        if ($request->has('sort')) {
            if ($request->input('sort') == 'low_high') {
                // Sorting by price after discount: price - discount (assuming discount is a percentage)
                $query->orderByRaw('(price * (1 - discount / 100)) asc');
            } elseif ($request->input('sort') == 'high_low') {
                // Sorting by price after discount: price - discount (assuming discount is a percentage)
                $query->orderByRaw('(price * (1 - discount / 100)) desc');
            }
        }

        // 6. Apply hide status filter (if needed, like products that are active)
        $query->where('hide_status', false);

        // Get the filtered products
        $products = $query->get();

        // Fetch all distinct sizes from the variants table
        $sizes = Variant::distinct()->pluck('size');

        // Fetch unique brands from the products table
        $brands = Product::distinct()->pluck('brand'); // Fetch distinct brands

        return view('cust.product', compact('products', 'sizes', 'brands'));
    }



}

// coba commit
// coba commit ft