<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function orderadmin()
    {
        $orders = Order::orderBy('id', 'desc')->get();
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

        // Define status sequences for both Shipping and Pick Up
        $shippingStatusSequence = [
            'pending' => 0,
            'dispatched' => 1,
            'in-transit' => 2,
            'delivered' => 3,
        ];

        $pickupStatusSequence = [
            'pending' => 0,
            'already pick up' => 1,
        ];

        // Get the current status and the new status
        $currentStatus = strtolower($order->shipping_status);
        $newStatus = strtolower($request->shipping_status);

        // Validate the status progression based on the current order type
        if ($order->status == 'Shipping') {
            // Ensure that we are not moving backwards in the Shipping flow
            if ($shippingStatusSequence[$newStatus] < $shippingStatusSequence[$currentStatus]) {
                return back()->with('error', 'You cannot move the shipping status backwards.');
            }
        } elseif ($order->status == 'Pick Up') {
            // Ensure that we are not moving backwards in the Pick Up flow
            if ($pickupStatusSequence[$newStatus] < $pickupStatusSequence[$currentStatus]) {
                return back()->with('error', 'You cannot move the pick-up status backwards.');
            }
        }

        // Validate the input
        $request->validate([
            'shipping_status' => 'required|string',
            'comment' => 'nullable|string',
        ]);

        // Update the order's shipping status
        $order->shipping_status = $request->shipping_status;
        $order->save();

        // If there's a comment, save it to the shippings table
        if ($request->comment) {
            $order->shippings()->create([
                'status' => $request->shipping_status,
                'comment' => $request->comment,
                'date' => now(),
            ]);
        }

        return redirect()->route('orderadmin')->with('success', 'Status updated successfully.');
    }

    public function orderManagement(Request $request)
    {
        $query = Order::query();

        // Filter by Order ID
        if ($request->has('order_id') && $request->order_id != '') {
            $query->where('id', 'like', '%' . $request->order_id . '%');
        }

        // Filter by Customer Name
        if ($request->has('customer_name') && $request->customer_name != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        // Filter by Address
        if ($request->has('address') && $request->address != '') {
            $query->where('shipping_address', 'like', '%' . $request->address . '%');
        }

        // Filter by Date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        // Filter by Status
        if ($request->has('status') && $request->status != '') {
            $query->where('shipping_status', $request->status);
        }

        // Fetch the filtered orders
        $orders = $query->get();

        return view('admin.orderpage', compact('orders'));
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
        // Pass the image URLs to the view
        return view('admin.create');
    }

    public function create_product(Request $request)
    {
        // Start a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Insert product data into the 'products' table
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'discount' => $request->discount ?? 0, // Default to 0 if no discount
                'brand' => $request->brand,
                'gender' => $request->gender,
                'description' => $request->description,
                'rating_avg' => 0,
                'total_reviews' => 0,
                'sold' => 0,
                'hide_status' => false,
            ]);

            // Insert variants (sizes and stock) into the 'variants' table
            if ($request->has('sizes')) {
                foreach ($request->sizes as $size => $stock) {

                    // Format size to one decimal place
                    $size = number_format((float)$size, 1, '.', ''); // Ensure the size is a float with one decimal place
                    
                    // If stock is empty, default it to 0
                    $stock = $stock ? $stock : 0; 

                    // Only insert if the size has a valid stock value (not null or 0)
                    if ($stock >= 0) {
                        Variant::create([
                            'size' => $size,
                            'stock' => $stock,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }

            // Handle image uploads and store in the 'images' table
            if ($request->hasFile('images')) {

                $imageCount = count($request->file('images'));

                // Check if the number of images exceeds 10
                if ($imageCount > 10) {
                    return redirect()->route('productadmin.show')->with('error', 'You can upload a maximum of 10 images.'); // Redirect back with an error message
                }

                $isMainImage = true;  // Mark the first image as the main image
                $productFolderPath = public_path('images/products/' . $product->id); // Create folder path based on product ID

                // Check if the product folder exists, if not, create it
                if (!File::exists($productFolderPath)) {
                    File::makeDirectory($productFolderPath, 0755, true);  // Create the directory if it doesn't exist
                }

                foreach ($request->file('images') as $image) {
                    $imageName = time() . '-' . $image->getClientOriginalName();
                    $image->move($productFolderPath, $imageName);  // Store image in the products folder

                    // Save image information to the images table
                    Image::create([
                        'url' => 'products/' . $product->id . '/' . $imageName,  // Store the relative path of the image
                        'main' => $isMainImage,                    // Mark the first image as the main image
                        'product_id' => $product->id,              // Link to the product
                    ]);

                    // After the first image, set subsequent ones as non-main
                    $isMainImage = false;
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('productadmin.show')
                ->with('success', 'Product successfully added!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Redirect with error message
            return redirect()->back()->with('error', 'Something went wrong. Please try again!');
        }
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

        // Check if this is a delete image request - HANDLE THIS FIRST
        if ($request->has('delete_image')) {
            $imageId = $request->delete_image;
            $image = Image::findOrFail($imageId);
            
            // Delete the file from storage
            $imagePath = public_path('images/' . $image->url);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            
            // Delete from database
            $image->delete();

            // Redirect back to the edit form
            return redirect()->back()->with('success', 'Image deleted successfully!');
        }
        

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

        // Handle image updates (adding images to existing folder)
        if ($request->hasFile('images') || !empty($request->keep_images)) {
            // Get current images
            $currentImages = $product->images;
            $keepImageIds = $request->keep_images ?? [];

            // Remove images that are not in keep_images array
            foreach ($currentImages as $image) {
                if (!in_array($image->id, $keepImageIds)) {
                    // Delete the file from storage
                    $imagePath = public_path('images/' . $image->url);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    // Delete from the database
                    $image->delete();
                }
            }

            // Get the product folder path
            $productFolderPath = public_path('images/products/' . $product->id); // Folder based on product ID

            // Check if the folder exists; if not, create it
            if (!File::exists($productFolderPath)) {
                File::makeDirectory($productFolderPath, 0755, true);  // Create the directory if it doesn't exist
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
                    // Generate a unique name for the image
                    $imageName = time() . '-' . $image->getClientOriginalName();  // Ensure unique image name

                    // Move the image to the product's folder
                    $image->move($productFolderPath, $imageName);  // Store image in the products folder

                    // Save the image to the database
                    Image::create([
                        'product_id' => $product->id,
                        'url' => 'products/' . $product->id . '/' . $imageName // Store the relative path
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

            
            // Option 2: Set stock to 0 for variants not in the form (safer approach)
            foreach ($existingVariants as $unusedVariant) {
                $unusedVariant->update(['stock' => 0]);
            }
        }



        DB::commit();

        return redirect()->route('productadmin.show') // Adjust this route name to your products listing route
            ->with('success', 'Product updated successfully!');
    }


    public function delete_product (Product $product){
        $product->delete();
        return redirect(route('productadmin.show'))->with('success', 'Product deleted!');
    }

    // Tambahkan method ini di ProductController Anda
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $products = Product::with('images')
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('brand', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get()
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
                
                // return [
                //     'id' => $product->id,
                //     'name' => $product->name,
                //     'price' => $product->price,
                //     'discount' => $product->discount,
                //     'brand' => $product->brand,
                //     'gender' => $product->gender,
                //     'description' => $product->description,
                //     'rating_avg' => $product->rating_avg,
                //     'total_reviews' => $product->total_reviews,
                //     'sold' => $product->sold,
                //     'final_rating' => $finalRating,
                //     'total_reviews_count' => $totalReviews,
                //     'total_sold_count' => $totalSold,
                //     'image_url' => $product->images->isNotEmpty() ? 
                //         asset('images/' . $product->images->first()->url) : null,
                //     'created_at' => $product->created_at,
                //     'updated_at' => $product->updated_at,
                // ];
            });
        
        // return response()->json([
        //     'success' => true,
        //     'products' => $products
        // ]);
        return view('admin.productadmin');
    }

}
