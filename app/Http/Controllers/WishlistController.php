<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function showWishlist()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('auth')->with('error', 'Please login to view your wishlist');
        }

        // Get wishlist items with product details
        $wishlist = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->leftJoin('images', function($join) {
                $join->on('products.id', '=', 'images.product_id')
                     ->whereRaw('images.id = (SELECT MIN(id) FROM images WHERE product_id = products.id)');
            })
            ->leftJoin(DB::raw('(SELECT product_id, AVG(rating) as rating_avg, COUNT(*) as total_reviews FROM reviews GROUP BY product_id) as review_stats'), 
                      'products.id', '=', 'review_stats.product_id')
            ->where('wishlists.user_id', $user->id)
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.brand',
                'products.gender',
                'products.price',
                'products.discount',
                'images.url as image',
                DB::raw('COALESCE(review_stats.rating_avg, 0) as rating_avg'),
                DB::raw('COALESCE(review_stats.total_reviews, 0) as total_reviews')
            )
            ->get()
            ->map(function($item) {
                // Format image path
                $item->image = $item->image ? 'images/' . $item->image : 'images/default-product.jpg';
                return $item;
            });

        return view('cust.wishlist', compact('wishlist'));
    }

    public function addToWishlist(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $productId = $request->input('product_id');
        
        // Check if product exists
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
                         ->where('product_id', $productId)
                         ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Product already in wishlist']);
        }

        // Add to wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId
        ]);

        return response()->json(['success' => true, 'message' => 'Product added to wishlist']);
    }

    public function removeFromWishlist(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $productId = $request->input('product_id');
        
        $deleted = Wishlist::where('user_id', $user->id)
                          ->where('product_id', $productId)
                          ->delete();

        if ($deleted) {
            return response()->json(['success' => true, 'message' => 'Product removed from wishlist']);
        } else {
            return response()->json(['success' => false, 'message' => 'Product not found in wishlist']);
        }
    }

    // public function toggleWishlist(Request $request)
    // {
    //     $user = Auth::user();
        
    //     if (!$user) {
    //         return response()->json(['success' => false, 'message' => 'Please login first'], 401);
    //     }

    //     $productId = $request->input('product_id');
        
    //     // Check if product exists
    //     $product = Product::find($productId);
    //     if (!$product) {
    //         return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    //     }

    //     // Check if already in wishlist
    //     $wishlistItem = Wishlist::where('user_id', $user->id)
    //                            ->where('product_id', $productId)
    //                            ->first();

    //     if ($wishlistItem) {
    //         // Remove from wishlist
    //         $wishlistItem->delete();
    //         return response()->json(['success' => true, 'action' => 'removed', 'message' => 'Product removed from wishlist']);
    //     } else {
    //         // Add to wishlist
    //         Wishlist::create([
    //             'user_id' => $user->id,
    //             'product_id' => $productId
    //         ]);
    //         return response()->json(['success' => true, 'action' => 'added', 'message' => 'Product added to wishlist']);
    //     }
    // }

    public function getWishlistStatus(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['wishlisted' => false]);
        }

        $productIds = $request->input('product_ids', []);
        
        if (empty($productIds)) {
            return response()->json(['wishlisted' => []]);
        }

        $wishlistedIds = Wishlist::where('user_id', $user->id)
                                ->whereIn('product_id', $productIds)
                                ->pluck('product_id')
                                ->toArray();

        $result = [];
        foreach ($productIds as $productId) {
            $result[$productId] = in_array($productId, $wishlistedIds);
        }

        return response()->json(['wishlisted' => $result]);
    }

    public function toggle(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('auth')->with('error', 'Please login first');
        }

        $productId = $request->input('product_id');

        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->exists();

        if ($exists) {
            Wishlist::where('user_id', $userId)->where('product_id', $productId)->delete();
            session()->flash('success', 'Removed from wishlist');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            session()->flash('success', 'Added to wishlist');
        }

        return redirect()->back();
    }

}

