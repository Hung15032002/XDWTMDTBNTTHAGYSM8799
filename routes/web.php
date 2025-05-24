<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BankTransactionController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\GmailController ;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\TempImagesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\DashboardController;




// Frontend Routes
Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/shop', [ShopController::class, 'index'])->name('front.shop');
Route::get('/shop/category/{id}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/subcategory-products/{id}', [FrontController::class, 'getProductsBySubcategory'])->name('front.subcategory.products');

Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.addToCart');

// Product Detail
Route::get('/productshow', [ProductShowController::class, 'index'])->name('front.productshow');
Route::get('/product/{id}', [ProductShowController::class, 'show'])->name('front.product.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/show', [CartController::class, 'showCart'])->name('cart.show');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/update-ajax', [CartController::class, 'ajaxUpdateCart'])->name('cart.update.ajax');
Route::post('/cart/remove-ajax', [CartController::class, 'ajaxRemoveItem'])->name('cart.remove.ajax');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment-success', [CheckoutController::class, 'showPaymentSuccess'])->name('payment.success');


// Admin Routes
Route::group(['prefix' => 'admin'], function() {
    Route::group(['Middleware' => 'admin.guest'], function() {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['Middleware' => 'admin.auth'], function() {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Category Routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Subcategory Routes
        Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
        Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
        Route::post('/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
        Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
        Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
        Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');

        // Brand Routes
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // Product Routes
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.ajax.destroy');

        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/admin/orders/{order}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');      
        Route::put('/admin/orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');


        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update'); 
        Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');
        

        Route::get('/gmail/auth', [GmailController::class, 'redirectToGoogle'])->name('gmail.auth');
        Route::get('/gmail/callback', [GmailController::class, 'handleGoogleCallback'])->name('gmail.callback');
        Route::get('/gmail/list', [GmailController::class, 'listEmails'])->name('gmail.list');  // Chỉ cần 1 route này cho việc hiển thị danh sách email
        Route::get('/gmail/email/{id}', [GmailController::class, 'viewEmail'])->name('gmail.view');  // Hiển thị chi tiết email

        
    });

    Route::get('/getSlug', function(Request $request) {
        // Khởi tạo biến $slug để tránh lỗi nếu không có title
        $slug = '';
    
        // Kiểm tra xem có title không
        if (!empty($request->title)) {
            $slug = Str::slug($request->title);
        }
    
        // Trả về response JSON với status và slug
        return response()->json([
            'status' => true,
            'slug' => $slug,
        ]);
    })->name('getSlug');

    // Route cho trang thông báo thanh toán thành công
    Route::get('payment-success', function () {
        return view('payment-success');
    })->name('admin.payment.success');

});
