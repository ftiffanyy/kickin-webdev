<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderCustController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;

// Route::get('/', function () {
//     return view('welcome');
// });

// //dashboard
// Route::get('/', [HomeController::class, 'show'])
// ->name('dashboard');

// //about us
// Route::get('/about', [HomeController::class, 'about'])->name('about');

// //auth
// Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth');

// // Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login'); // dummy handler

// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
// Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');
// //logout
// Route::post('/logout', function () {
//     session()->flush();
//     return redirect('/auth');
// })->name('logout');

// //contact
// Route::post('/contact/send', [HomeController::class, 'send'])->name('contact.send');
// Route::get('/contact', function () {
//     return view('cust.contact');
// })->name('contact');

// //terms
// Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
// //Privacy 
// Route::get('/Privacy', [HomeController::class, 'Privacy'])->name('Privacy');
// //FAQ 
// Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// //products
// // liat produk semua (HEADER)
// Route::get('/product', [ProductController::class, 'show'])->name('product.show');
// // liat detail produk pas diklik
// Route::get('/product/view/{id}', [ProductController::class, 'showDetail'])->name('product.details');
// // fungsi add to cart
// Route::post('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('add_to_cart');
// // liat cart (HEADER)
// Route::get('/cart', [ProductController::class, 'cart'])->name('view_cart');
// // fungsi update cart (quantity & remove)
// Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('update_cart');
// // filter product
// Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
// //page checkout
// Route::post('/copage', [ProductController::class, 'copage'])->name('copage');
// //fungsi checkout
// Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
// //wishlist
// Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist');

// //orders
// Route::get('/orders', [OrderCustController::class, 'show'])->name('order_customer');
// //order details
// Route::get('/order-details/{id}', [OrderCustController::class, 'orderdetails'])->name('order_details');




// //ADMIN
// Route::get('/admin', [HomeController::class, 'admin'])
// ->name('dashboard_admin');
// // liat produk semua versi admin (HEADER)
// Route::get('/productadmin', [ProductController::class, 'showadmin'])->name('productadmin.show');
// // liat form create
// Route::get('/product/create-form', [ProductController::class, 'create_product_form'])->name('create_product_form');
// // proses create
// Route::post('/product/create', [ProductController::class, 'create_product'])->name('create_product');

// // harusnya ada parameter id (tp nanti aja setelah ada database)
// // liat form edit
// Route::get('/product/edit-form', [ProductController::class, 'edit_product_form'])->name('edit_product_form');
// // proses edit (hrsnya put dan ada parameter id)
// Route::post('/product/update', [ProductController::class, 'update_product'])->name('update_product');

// //order admin
// Route::get('/orderadmin', [AdminController::class, 'orderadmin'])->name('orderadmin');
// //order details admin
// Route::get('/orderdadmin/{orderid}', [AdminController::class, 'orderdadmin'])->name('order_details_admin');


Route::get('/auth', [AuthController::class, 'showAuth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login'); // dummy handler

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.send');

// Routes tambahan untuk reset password (perlu ditambahkan)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth'])->group(function(){
    Route::get('/about', [HomeController::class, 'about'])->name('about');

    Route::post('/logout', function () {
        session()->flush();
        return redirect('/auth');
    })->name('logout');

    Route::get('/terms', [HomeController::class, 'terms'])->name('terms');

    Route::get('/Privacy', [HomeController::class, 'Privacy'])->name('Privacy');

    Route::get('/contact', function () {
        return view('cust.contact');
    })->name('contact');

    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

    Route::middleware(['role:Customer'])->group(function(){
        //dashboard
        Route::get('/', [HomeController::class, 'show'])
        ->name('dashboard');
        //products
        // liat produk semua (HEADER)
        Route::get('/product', [ProductController::class, 'show'])->name('product.show');
        // liat detail produk pas diklik
        Route::get('/product/view/{id}', [ProductController::class, 'showDetail'])->name('product.details');
        // fungsi add to cart
        Route::post('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('add_to_cart');
        // liat cart (HEADER)
        Route::get('/cart', [ProductController::class, 'cart'])->name('view_cart');
        // fungsi update cart (quantity & remove)
        Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('update_cart');
        // filter product
        Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');
        //page checkout
        Route::match(['get', 'post'], 'copage', [ProductController::class, 'copage'])->name('copage');
        Route::post('/copage-buynow', [ProductController::class, 'copageBuyNow'])->name('copage_buynow');
        //fungsi checkout
        Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
        //wishlist
        Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist');
        Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
        Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
        // Route::post('/wishlist/toggle', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::post('/wishlist/status', [WishlistController::class, 'getWishlistStatus'])->name('wishlist.status');
        //orders
        Route::get('/orders', [OrderCustController::class, 'show'])->name('order_customer');
        //order details
        Route::get('/order-details/{id}', [OrderCustController::class, 'orderdetails'])->name('order_details');
        Route::post('/order/{order_id}/product/{product_id}/review', [OrderCustController::class, 'submitReview'])->name('review_submit');
    });

    Route::middleware(['role:Admin'])->group(function(){
        //ADMIN
        Route::get('/admin', [HomeController::class, 'admin'])->name('dashboard_admin');
        // liat produk semua versi admin (HEADER)
        Route::get('/productadmin', [AdminController::class, 'showadmin'])->name('productadmin.show');
        // details
        Route::get('/product/viewadmin/{id}', [AdminController::class, 'showDetailAdmin'])->name('productadmin.details');
       
        // liat form create
        Route::get('/product/create-form', [AdminController::class, 'create_product_form'])->name('create_product_form');
        // proses create
        Route::post('/product/create', [AdminController::class, 'create_product'])->name('create_product');

        // EDIT (DONE)
        // liat form edit
        Route::get('/product/edit-form/{id}', [AdminController::class, 'edit_product_form'])->name('edit_product_form');
        // proses edit (hrsnya put dan ada parameter id)
        Route::put('/product/update/{id}', [AdminController::class, 'update_product'])->name('update_product');

        //order admin
        Route::get('/orderadmin', [AdminController::class, 'orderadmin'])->name('orderadmin');
        //order details admin
        Route::get('/orderdadmin/{orderid}', [AdminController::class, 'orderdadmin'])->name('order_details_admin');
        //update status shipping
        Route::post('/order/{id}/update-status', [AdminController::class, 'updateStatus'])->name('order.updateStatus');
    });
});
