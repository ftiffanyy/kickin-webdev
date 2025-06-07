<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    // Method for displaying the edit product form with dynamic data from the database
    public function edit_product_form($id)
    {
        try {
            // Fetch the product with its related data
            $product = Product::with(['images', 'variants'])->findOrFail($id);
            
            return view('admin.edit', compact('product'));
            
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product not found');
        }
    }



    public function update_product(Request $request, $id)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'brand' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Unisex',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'nullable|integer|min:0',
            'keep_images' => 'nullable|array',
            'keep_images.*' => 'integer'
        ]);


        DB::beginTransaction();

        // Find the product
        $product = Product::findOrFail($id);

        // Update product basic information
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount,
            'brand' => $request->brand,
            'gender' => $request->gender,
            'description' => $request->description,
        ]);

        // Handle image updates
        if ($request->hasFile('images') || !empty($request->keep_images)) {
            // Get current images
            $currentImages = $product->images;
            $keepImageIds = $request->keep_images ?? [];

            // Remove images that are not in keep_images array
            foreach ($currentImages as $image) {
                if (!in_array($image->id, $keepImageIds)) {
                    // Delete file from storage
                    if (Storage::disk('public')->exists($image->image_url)) {
                        Storage::disk('public')->delete($image->image_url);
                    }
                    // Delete from database
                    $image->delete();
                }
            }

            // Add new images
            if ($request->hasFile('images')) {
                $existingImageCount = count($keepImageIds);
                $newImageCount = count($request->file('images'));
                
                // Check total image limit (max 10)
                if (($existingImageCount + $newImageCount) > 10) {
                    DB::rollBack();
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Maximum 10 images allowed. You have ' . $existingImageCount . ' existing images.');
                }

                foreach ($request->file('images') as $image) {
                    // Store the image
                    $imagePath = $image->store('products', 'public');
                        
                    // Save to database
                    Image::create([
                        'product_id' => $product->id,
                        'url' => $imagePath
                    ]);
                }
            }
        }

        // Handle sizes update
        if ($request->has('sizes')) {
            // Get all existing variants for the product
            $existingVariants = Variant::where('product_id', $product->id)->get()->keyBy('size');

            foreach ($request->sizes as $size => $stock) {
                // Convert stock to integer, treat empty as 0
                $stock = intval($stock);
                
                // Check if the size exists in the existing variants
                if (isset($existingVariants[$size])) {
                    // If variant exists, update its stock (even if stock is 0)
                    $existingVariants[$size]->update([
                        'stock' => $stock
                    ]);
                    
                    // Remove from collection so we know it was processed
                    unset($existingVariants[$size]);
                } else {
                    // // If variant doesn't exist and stock > 0, create new variant
                    // if ($stock > 0) {
                    //     Variant::create([
                    //         'product_id' => $product->id,
                    //         'size' => $size,
                    //         'stock' => $stock
                    //     ]);
                    // }
                }
            }
            
            // Handle any existing variants that weren't in the request
            // Option 1: Delete variants not in the form (uncomment if needed)
            // foreach ($existingVariants as $unusedVariant) {
            //     $unusedVariant->delete();
            // }
            
            // Option 2: Set stock to 0 for variants not in the form (safer approach)
            foreach ($existingVariants as $unusedVariant) {
                $unusedVariant->update(['stock' => 0]);
            }
        }



        DB::commit();

        return redirect()->route('productadmin.show') // Adjust this route name to your products listing route
            ->with('success', 'Product updated successfully!');


    }


}
