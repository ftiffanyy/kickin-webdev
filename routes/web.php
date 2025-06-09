<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderCustController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;

use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'show'])
        ->name('dashboard');

Route::get('/login', [AuthController::class, 'showAuth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login'); // dummy handler

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.send');

Route::get('/otp', [AuthController::class, 'showOtpForm'])->name('otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
Route::get('/password/reset/{email}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/update-password/{email}', [AuthController::class, 'updatePassword'])->name('password.update');

// liat produk semua (HEADER)
Route::get('/product', [ProductController::class, 'show'])->name('product.show');
// filter product
Route::get('/products/filter', [ProductController::class, 'filterProducts'])->name('products.filter');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/Privacy', [HomeController::class, 'Privacy'])->name('Privacy');

Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/about', [HomeController::class, 'about'])->name('about');
//wishlist
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::middleware(['auth'])->group(function(){
    // Route::get('/contact', function () {
    //     return view('cust.contact');
    // })->name('contact');
    

    Route::post('/logout', function () {
        session()->flush();
        return redirect('/login');
    })->name('logout');



    Route::middleware(['role:Customer'])->group(function(){
        //dashboard
        // Route::get('/', [HomeController::class, 'show'])
        // ->name('dashboard');
        //products
        // liat produk semua (HEADER)
        // Route::get('/product', [ProductController::class, 'show'])->name('product.show');
        // liat detail produk pas diklik
        Route::get('/product/view/{id}', [ProductController::class, 'showDetail'])->name('product.details');
        // fungsi add to cart
        Route::post('/add-to-cart/{productId}', [ProductController::class, 'addToCart'])->name('add_to_cart');
        // liat cart (HEADER)
        Route::get('/cart', [ProductController::class, 'cart'])->name('view_cart');
        // fungsi update cart (quantity & remove)
        Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('update_cart');

        //page checkout
        Route::match(['get', 'post'], 'copage', [ProductController::class, 'copage'])->name('copage');
        Route::post('/copage-buynow', [ProductController::class, 'copageBuyNow'])->name('copage_buynow');
        //fungsi checkout
        Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
        //wishlist
        Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist');
        Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
        Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
        // Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::post('/wishlist/status', [WishlistController::class, 'getWishlistStatus'])->name('wishlist.status');
        //orders
        Route::get('/orders', [OrderCustController::class, 'show'])->name('order_customer');
        //order details
        Route::get('/order-details/{id}', [OrderCustController::class, 'orderdetails'])->name('order_details');
        Route::post('/order/{order_id}/product/{product_id}/review', [OrderCustController::class, 'submitReview'])->name('review_submit');
    });

    Route::middleware(['role:Admin'])->group(function(){
        //ADMIN
        Route::get('/admin', [HomeController::class, 'showDashboard'])->name('dashboard_admin');
        // liat produk semua versi admin (HEADER)
        Route::get('/productadmin', [AdminController::class, 'showadmin'])->name('productadmin.show');
        // details
        Route::get('/product/viewadmin/{id}', [AdminController::class, 'showDetailAdmin'])->name('productadmin.details');
 
        // Tambahkan route ini di routes/web.php
        Route::post('/admin/products/search', [AdminController::class, 'search'])->name('productadmin.search');
        // liat form create
        Route::get('/product/create-form', [AdminController::class, 'create_product_form'])->name('create_product_form');
        // proses create
        Route::post('/product/create', [AdminController::class, 'create_product'])->name('create_product');

        // EDIT (DONE)
        // liat form edit
        Route::get('/product/edit-form/{id}', [AdminController::class, 'edit_product_form'])->name('edit_product_form');
        // proses edit (hrsnya put dan ada parameter id)
        Route::put('/product/update/{id}', [AdminController::class, 'update_product'])->name('update_product');

        // delete
        Route::delete('/product/delete/{product:id}', [AdminController::class, 'delete_product'])->name('delete_product');

        //order admin
        Route::get('/orderadmin', [AdminController::class, 'orderadmin'])->name('orderadmin');
        // order filter
        Route::get('/order-management', [AdminController::class, 'orderManagement'])->name('order_management');
        //order details admin
        Route::get('/orderdadmin/{orderid}', [AdminController::class, 'orderdadmin'])->name('order_details_admin');
        //update status shipping
        Route::post('/order/{id}/update-status', [AdminController::class, 'updateStatus'])->name('order.updateStatus');



        Route::get('/contacts', [ContactController::class, 'adminIndex'])->name('admin.contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contacts.show');
        Route::patch('/contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('admin.contacts.mark-read');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    });
});
