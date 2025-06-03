<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
    
    public function showadmin()
    {
        // Fetch products from the database
        $products = Product::all();

        return view('admin.productadmin', compact('products'));
    }

    
    public function showDetailAdmin($id)
    {
        // Fetch the product by ID
        $products = Product::findOrFail($id);

        // Fetch the variants (sizes and stock) for the product
        $availableSizes = $products->variants->pluck('stock', 'size'); // Plucking stock and size

        // Fetch all images for the product
        $images = $products->images()->get(); // Get all images

        // Return the product details view with the data
        return view('admin.detailsadmin', compact('products', 'images', 'availableSizes'));
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


}
