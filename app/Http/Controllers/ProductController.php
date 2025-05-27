<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function show()
    {
        // Fetch products from the database
        $products = Product::all(); // Or you can filter with where conditions if needed

        // Pass the products to the view
        return view('cust.product', compact('products'));

        // $role = session('user_role', 'Guest');

        // if ($role === 'Admin') {
        //     return view('admin.productadmin', compact('products'));
        // } elseif ($role === 'User') {
        //     return view('cust.product', compact('products'));
        // }
        
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




    public function addToCart(Request $request, $productId)
    {

        // Hardcoded product data
        $products = [
            1 => [
                'product_id' => 1,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - WHITE",
                'price' => 1549000,
                'discount' => 30,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Step into a legend with the Nike Air Force 1 '07. Featuring crisp white leather and classic hoops-inspired style, this icon brings timeless street appeal and durable comfort. Padded collars and Nike Air cushioning provide all-day support on and off the court.",
                'rating_avg' => 4.4,
                'total_reviews' => 102,
                'sold' => 1323,
                'image' => $this->getFirstImage(1),
            ],
            2 => [
                'product_id' => 2,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - BLACK",
                'price' => 1549000,
                'discount' => 10,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Bold and iconic, the Nike Air Force 1 '07 in black delivers classic basketball style with a modern street edge. Premium materials and perforated toe details ensure comfort and breathability, while the Nike Air unit softens every step.",
                'rating_avg' => 4.8,
                'total_reviews' => 94,
                'sold' => 1240,
                'image' => $this->getFirstImage(2),
            ],
            3 => [
                'product_id' => 3,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - BLACK",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Originally made for Formula 1 drivers, the Speedcat OG returns as a lifestyle icon. Sleek black suede and a low-profile silhouette offer motorsport heritage and street-ready style for everyday wear.",
                'rating_avg' => 4.6,
                'total_reviews' => 76,
                'sold' => 796,
                'image' => $this->getFirstImage(3),
            ],
            4 => [
                'product_id' => 4,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - RED",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Drive your street style with the Speedcat OG in vibrant red. Inspired by the fast lane, this sleek silhouette brings racing DNA into your daily rotation with rich suede and a heritage motorsport vibe.",
                'rating_avg' => 4.5,
                'total_reviews' => 98,
                'sold' => 925,
                'image' => $this->getFirstImage(4),
            ],
            5 => [
                'product_id' => 5,
                'product_name' => "PALERMO MODA VINTAGE WOMEN'S LIFESTYLE SHOES - BLUE",
                'price' => 1599000,
                'discount' => 10,
                'brand' => 'PUMA',
                'gender' => 'Women',
                'description' => "Channel vintage Italian flair with the Palermo Moda. This women's sneaker pairs a vibrant blue suede upper with retro charm and everyday comfort, making it a perfect choice for relaxed and stylish days.",
                'rating_avg' => 4.3,
                'total_reviews' => 45,
                'sold' => 570,
                'image' => $this->getFirstImage(5),
            ],    
            6 => [
                'product_id' => 6,
                'product_name' => "530 UNISEX SNEAKERS SHOES - SILVER",
                'price' => 1599000,
                'discount' => 30,
                'brand' => 'NEW BALANCE',
                'gender' => 'Unisex',
                'description' => "The New Balance 530 blends retro running style with modern comfort. A standout silver finish and ABZORB cushioning create a bold and cushy ride for all-day exploration in timeless fashion.",
                'rating_avg' => 4.2,
                'total_reviews' => 154,
                'sold' => 1620,
                'image' => $this->getFirstImage(6),
            ],       
            7 => [
                'product_id' => 7,
                'product_name' => "MR530 MEN'S RUNNING SHOES - WHITE WITH NATURAL INDIGO",
                'price' => 1599000,
                'discount' => 0,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "Run the streets with the MR530 in fresh white and natural indigo. Designed for both performance and daily wear, it combines breathable mesh, durable overlays, and advanced cushioning to keep you moving in comfort and style.",
                'rating_avg' => 4.7,
                'total_reviews' => 123,
                'sold' => 1096,
                'image' => $this->getFirstImage(7),
            ],
            8 => [
                'product_id' => 8,
                'product_name' => "550 MEN'S SNEAKERS - BLACK",
                'price' => 2099000,
                'discount' => 50,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "A true throwback from the archives, the New Balance 550 in sleek black revives basketball-inspired heritage with a streetwear twist. Leather overlays and a classic build deliver bold style with everyday durability.",
                'rating_avg' => 3.7,
                'total_reviews' => 68,
                'sold' => 612,
                'image' => $this->getFirstImage(8),
            ],
            9 => [
                'product_id' => 9,
                'product_name' => "OLD SKOOL UNISEX SNEAKERS SHOES - BLACK",
                'price' => 999000,
                'discount' => 0,
                'brand' => 'VANS',
                'gender' => 'Unisex',
                'description' => "The Vans Old Skool is a timeless icon. This black unisex version features signature side stripes, sturdy canvas and suede uppers, and the original waffle sole. Perfect for skaters and casual creatives alike.",
                'rating_avg' => 4.9,
                'total_reviews' => 13,
                'sold' => 112,
                'image' => $this->getFirstImage(9),
            ],
            10 => [
                'product_id' => 10,
                'product_name' => "SAMBAE WOMEN'S SNEAKERS - FTWR WHITE",
                'price' => 2200000,
                'discount' => 50,
                'brand' => 'ADIDAS',
                'gender' => 'Women',
                'description' => "Rediscover movement with the Sambae Women’s Sneakers in Footwear White. This fresh take on a classic archive style features a supportive fit, durable synthetic upper, and lightweight EVA midsole ideal for urban exploration and everyday comfort.",
                'rating_avg' => 4.8,
                'total_reviews' => 113,
                'sold' => 1118,
                'image' => $this->getFirstImage(10),
            ],
        ];
        // Retrieve the quantity from the request
        $quantity = $request->input('quantity', 1); // Default to 1 if not provided

        // Retrieve the product based on the productId
        $product = $products[$productId] ?? null;

        // If the product doesn't exist, return an error
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        // Calculate the discounted price
        $discountedPrice = $product['price'] - ($product['price'] * $product['discount'] / 100);

        // Get the cart session
        $cart = session()->get('cart', []);

        // If the product is already in the cart, update the quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // If the product is not in the cart, add it
            $cart[$productId] = [
                'name' => $product['product_name'],
                'price' => $discountedPrice,  // Use the discounted price here
                'quantity' => $quantity,
                'image' => $product['image'],
            ];
        }

        // Update the session cart
        session()->put('cart', $cart);

        // Return to the previous page with a success message
        return redirect()->back()->with('success', 'Product added to cart!');

    }

    public function cart()
    {
        // Retrieve the cart session
        $cart = session()->get('cart', []);

        // Return the view with the cart data
        return view('cust.cart', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        // Get the current cart session
        $cart = session()->get('cart', []);

        // Get the updated quantities from the request
        $quantities = $request->input('quantity', []);
        // Get the selected items to be removed
        $selectedItems = $request->input('selected_items', []);

        // Process quantity updates
        foreach ($quantities as $id => $newQuantity) {
            // Ensure the quantity is not less than 1
            $newQuantity = max(1, (int) $newQuantity);

            // If the product is in the cart, update the quantity
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $newQuantity;
            }
        }

        // Remove the selected items from the cart
        foreach ($selectedItems as $itemId) {
            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);  // Remove the item from the cart
            }
        }

        // Save the updated cart in session
        session()->put('cart', $cart);
        return redirect()->route('view_cart')->with('success', 'Cart updated successfully!');
    }


    // create product form
    public function create_product_form()
    {
        // sementara
        // Define the product folder
        $productId = 10;  // Product with ID 10
        $imagesPath = public_path("images/products/{$productId}");

        // If the folder exists, get the image files
        $imageUrls = [];
        if (File::exists($imagesPath)) {
            $images = File::files($imagesPath);
            
            // Generate the image URLs (you can manually define these if you know the file names)
            foreach ($images as $image) {
                $imageUrls[] = asset("images/products/{$productId}/" . $image->getFilename());
            }
        }


        // Pass the image URLs to the view
        return view('admin.create', compact('imageUrls'));
    }

    public function create_product(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'brand' => 'required|string|max:255',
            'gender' => 'required|in:Unisex,Men,Woman',
            'description' => 'required|string',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|numeric|min:0', // Ensuring the quantity is numeric
        ], [
            'product_name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'brand.required' => 'Merek produk wajib diisi.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'images.*.image' => 'Hanya gambar yang boleh diunggah.',
            'sizes.*.numeric' => 'Jumlah stok harus berupa angka.',
        ]);

        // Handle image uploads
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;  // Store image names
            }
        }

        // Simulate success (no actual database insert)
        return redirect()->route('productadmin.show')
            ->with('success', 'Product successfully added!')
            ->with('imageUrls', $imageNames); // Add imageUrls in session if needed
    }


    // Method for displaying the edit product form with hardcoded data
    public function edit_product_form()
    {
        $product_data = [
            'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - WHITE",
            'price' => 1549000,
            'discount' => 30,
            'brand' => 'NIKE',
            'gender' => 'Men',
            'description' => "Step into a legend with the Nike Air Force 1 '07. Featuring crisp white leather and classic hoops-inspired style, this icon brings timeless street appeal and durable comfort. Padded collars and Nike Air cushioning provide all-day support on and off the court.",
            'rating_avg' => 4.4,
            'total_reviews' => 102,
            'sold' => 1323,
        ];

        $existingQuantities = [
            '35' => 0,
            '35.5' => 0,
            '36' => 0,
            '36.5' => 0,
            '37' => 0,
            '37.5' => 0,
            '38' => 5,
            '38.5' => 5,
            '39' => 5,
            '39.5' => 5,
            '40' => 5,
            '40.5' => 5,
            '41' => 5,
            '41.5' => 5,
            '42' => 5,
            '42.5' => 5,
            '43' => 5,
            '43.5' => 5,
            '44' => 5,
            '44.5' => 5,
            '45' => 5,
            '45.5' => 5,
            '46' => 5,
        ];

        $productId = 1;  
        $imagesPath = public_path("images/products/{$productId}");

        // If the folder exists, get the image files
        $imageUrls = [];
        if (File::exists($imagesPath)) {
            $images = File::files($imagesPath);
            
            // Generate the image URLs (you can manually define these if you know the file names)
            foreach ($images as $image) {
                $imageUrls[] = asset("images/products/{$productId}/" . $image->getFilename());
            }
        }

        // Pass the hardcoded data and image URLs to the edit product view
        return view('admin.edit', compact('product_data', 'existingQuantities', 'imageUrls'));
    }


    public function update_product(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'brand' => 'required|string|max:255',
            'gender' => 'required|in:Unisex,Men,Woman',
            'description' => 'required|string',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|numeric|min:0', // Ensuring the quantity is numeric
        ], [
            'product_name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'brand.required' => 'Merek produk wajib diisi.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'images.*.image' => 'Hanya gambar yang boleh diunggah.',
            'sizes.*.numeric' => 'Jumlah stok harus berupa angka.',
        ]);

        
        // Handle image uploads
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images'), $imageName);
                $imageNames[] = $imageName;  // Store image names
            }
        }

        // Simulate success (no actual database insert)
        return redirect()->route('productadmin.show')
            ->with('success', 'Product successfully updated!')
            ->with('imageUrls', $imageNames); // Add imageUrls in session if needed
    }


        public function showadmin()
    {
        // Hardcoded product data
        $products = [
            [
                'product_id' => 1,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - WHITE",
                'price' => 1549000,
                'discount' => 30,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Step into a legend with the Nike Air Force 1 '07. Featuring crisp white leather and classic hoops-inspired style, this icon brings timeless street appeal and durable comfort. Padded collars and Nike Air cushioning provide all-day support on and off the court.",
                'rating_avg' => 4.4,
                'total_reviews' => 102,
                'sold' => 1323,
                'image' => $this->getFirstImage(1), // Get first image for product 1
            ],
            [
                'product_id' => 2,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - BLACK",
                'price' => 1549000,
                'discount' => 10,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Bold and iconic, the Nike Air Force 1 '07 in black delivers classic basketball style with a modern street edge. Premium materials and perforated toe details ensure comfort and breathability, while the Nike Air unit softens every step.",
                'rating_avg' => 4.8,
                'total_reviews' => 94,
                'sold' => 1240,
                'image' => $this->getFirstImage(2), // Get first image for product 2
            ],
            [
                'product_id' => 3,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - BLACK",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Originally made for Formula 1 drivers, the Speedcat OG returns as a lifestyle icon. Sleek black suede and a low-profile silhouette offer motorsport heritage and street-ready style for everyday wear.",
                'rating_avg' => 4.6,
                'total_reviews' => 76,
                'sold' => 796,
                'image' => $this->getFirstImage(3),
            ],
            [
                'product_id' => 4,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - RED",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Drive your street style with the Speedcat OG in vibrant red. Inspired by the fast lane, this sleek silhouette brings racing DNA into your daily rotation with rich suede and a heritage motorsport vibe.",
                'rating_avg' => 4.5,
                'total_reviews' => 98,
                'sold' => 925,
                'image' => $this->getFirstImage(4),
            ],
            [
                'product_id' => 5,
                'product_name' => "PALERMO MODA VINTAGE WOMEN'S LIFESTYLE SHOES - BLUE",
                'price' => 1599000,
                'discount' => 10,
                'brand' => 'PUMA',
                'gender' => 'Women',
                'description' => "Channel vintage Italian flair with the Palermo Moda. This women's sneaker pairs a vibrant blue suede upper with retro charm and everyday comfort, making it a perfect choice for relaxed and stylish days.",
                'rating_avg' => 4.3,
                'total_reviews' => 45,
                'sold' => 570,
                'image' => $this->getFirstImage(5),
            ],
            [
                'product_id' => 6,
                'product_name' => "530 UNISEX SNEAKERS SHOES - SILVER",
                'price' => 1599000,
                'discount' => 30,
                'brand' => 'NEW BALANCE',
                'gender' => 'Unisex',
                'description' => "The New Balance 530 blends retro running style with modern comfort. A standout silver finish and ABZORB cushioning create a bold and cushy ride for all-day exploration in timeless fashion.",
                'rating_avg' => 4.2,
                'total_reviews' => 154,
                'sold' => 1620,
                'image' => $this->getFirstImage(6),
            ],
            [
                'product_id' => 7,
                'product_name' => "MR530 MEN'S RUNNING SHOES - WHITE WITH NATURAL INDIGO",
                'price' => 1599000,
                'discount' => 0,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "Run the streets with the MR530 in fresh white and natural indigo. Designed for both performance and daily wear, it combines breathable mesh, durable overlays, and advanced cushioning to keep you moving in comfort and style.",
                'rating_avg' => 4.7,
                'total_reviews' => 123,
                'sold' => 1096,
                'image' => $this->getFirstImage(7),
            ],
            [
                'product_id' => 8,
                'product_name' => "550 MEN'S SNEAKERS - BLACK",
                'price' => 2099000,
                'discount' => 50,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "A true throwback from the archives, the New Balance 550 in sleek black revives basketball-inspired heritage with a streetwear twist. Leather overlays and a classic build deliver bold style with everyday durability.",
                'rating_avg' => 3.7,
                'total_reviews' => 68,
                'sold' => 612,
                'image' => $this->getFirstImage(8),
            ],
            [
                'product_id' => 9,
                'product_name' => "OLD SKOOL UNISEX SNEAKERS SHOES - BLACK",
                'price' => 999000,
                'discount' => 0,
                'brand' => 'VANS',
                'gender' => 'Unisex',
                'description' => "The Vans Old Skool is a timeless icon. This black unisex version features signature side stripes, sturdy canvas and suede uppers, and the original waffle sole. Perfect for skaters and casual creatives alike.",
                'rating_avg' => 4.9,
                'total_reviews' => 13,
                'sold' => 112,
                'image' => $this->getFirstImage(9),
            ],
            [
                'product_id' => 10,
                'product_name' => "SAMBAE WOMEN'S SNEAKERS - FTWR WHITE",
                'price' => 2200000,
                'discount' => 50,
                'brand' => 'ADIDAS',
                'gender' => 'Women',
                'description' => "Rediscover movement with the Sambae Women’s Sneakers in Footwear White. This fresh take on a classic archive style features a supportive fit, durable synthetic upper, and lightweight EVA midsole ideal for urban exploration and everyday comfort.",
                'rating_avg' => 4.8,
                'total_reviews' => 113,
                'sold' => 1118,
                'image' => $this->getFirstImage(10),
            ],
        ];

        return view('admin.productadmin', compact('products'));
    }

    public function copage(Request $request)
    {
        return view('cust.copage');
    }

    public function checkout(Request $request)
    {
        return redirect()->route('order_customer')->with('success', 'Checkout Complete!');
    }

    public function filter(Request $request)
    {
        // Ambil semua produk (collection)
        $products = Product::all(); // harus return collection

        // Filter by gender
        if ($request->filled('gender')) {
            $products = $products->filter(function ($product) use ($request) {
                return strtolower($product['gender']) === strtolower($request->gender);
            });
        }

        // Filter by color
        if ($request->filled('color')) {
            $products = $products->filter(function ($product) use ($request) {
                return isset($product['color']) && strtolower($product['color']) === strtolower($request->color);
            });
        }

        // Filter by size
        if ($request->filled('size')) {
            $products = $products->filter(function ($product) use ($request) {
                return isset($product['size']) && strtolower($product['size']) === strtolower($request->size);
            });
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $products = $products->filter(function ($product) use ($request) {
                return strtolower($product['brand']) === strtolower($request->brand);
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            if ($request->sort === 'low_high') {
                $products = $products->sortBy('price');
            } elseif ($request->sort === 'high_low') {
                $products = $products->sortByDesc('price');
            } elseif ($request->sort === 'relevance') {
                // contoh sort by rating_avg descending
                $products = $products->sortByDesc('rating_avg');
            }
        }

        // Kalau mau pagination manual, bisa slice collection di sini (optional)
        // Misal: $products = $products->slice(0, 20);

        // Kembalikan view dengan products (jangan lupa reset index collection)
        return view('product.index', ['products' => $products->values()]);
    }

}

// coba commit
// coba commit ft