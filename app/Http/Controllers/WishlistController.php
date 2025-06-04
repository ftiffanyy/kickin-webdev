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
        // Ambil data user yang sedang login
        $user = Auth::user();
        
        // Jika user tidak login, arahkan ke halaman login
        if (!$user) {
            return redirect()->route('auth')->with('error', 'Please login to view your wishlist');
        }

        // Mengambil data wishlist yang terkait dengan user
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
                // Format path image
                $item->image = $item->image ? 'images/' . $item->image : 'images/default-product.jpg';
                return $item;
            });

        // Return ke view dengan data wishlist
        return view('cust.wishlist', compact('wishlist'));
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

