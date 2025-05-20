<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WishlistController extends Controller
{
    public function showWishlist()
    {
        // Hardcoded wishlist data (for demo purposes)
        $wishlist = [
            [
                'product_id' => 1,
                'product_name' => "Nike Air Force 1 '07 White",
                'price' => 1549000,
                'discount' => 30,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'rating_avg' => 4.4,
                'total_reviews' => 102,
                'image' => $this->getFirstImage(1), // Adjust the path based on your structure
            ],
            // Add more products here...
            [
                'product_id' => 4,
                'product_name' => "Speedcat OG Unisex Lifestyle Shoes - Red",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'rating_avg' => 4.5,
                'total_reviews' => 98,
                'image' => $this->getFirstImage(4), // Adjust the path based on your structure
            ],
        ];

        // Return the wishlist view with data
        return view('cust.wishlist', compact('wishlist'));
    }



    public function addToWishlist($productId)
    {
        // Logic for adding product to wishlist (You can use session or database to store the wishlist)
        return redirect()->route('wishlist')->with('success', 'Product added to wishlist!');
    }

    public function removeFromWishlist($productId)
    {
        // Logic to remove product from wishlist
        // e.g., remove it from the session or database if implemented

        // Example (assuming using session for wishlist)
        $wishlist = session()->get('wishlist', []);

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
        }

        // Save the updated wishlist back to session
        session()->put('wishlist', $wishlist);

        return redirect()->route('wishlist')->with('success', 'Product removed from wishlist!');
    }

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

    // In WishlistController.php
    public function toggleWishlist(Request $request, $productId)
    {
        $isInWishlist = $request->input('is_in_wishlist', false);

        // Store the wishlist status (in session or database)
        if ($isInWishlist) {
            // Add to wishlist logic (e.g., save to session or database)
        } else {
            // Remove from wishlist logic
        }

        return response()->json(['status' => 'success']);
    }


}