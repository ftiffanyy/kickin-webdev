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

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.send');

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
        Route::get('/', [HomeController::class, 'show'])->name('dashboard');
        Route::get('/product', [ProductController::class, 'show'])->name('product.show');
        Route::get('/orders', [OrderCustController::class, 'show'])->name('order_customer');
        Route::get('/cart', [ProductController::class, 'cart'])->name('view_cart');
        Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist');
    });

    Route::middleware(['role:Admin'])->group(function(){
        Route::get('/admin', [HomeController::class, 'admin'])->name('dashboard_admin');
    });
});
Route::get('/debug', function () {
    dd(Auth::check(), Auth::user()->role);
});