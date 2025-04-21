<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Adminlogincontroller;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\SubcategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'admin'],function(){

    Route::group(['Middleware' => 'admin.guest'],function(){

    Route::get('/login', [Adminlogincontroller::class, 'index'])->name('admin.login');
    Route::post('/authenticate', [Adminlogincontroller::class, 'authenticate'])->name('admin.authenticate');

    // Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
});
Route::group(['Middleware' => 'admin.auth'],function(){

    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

    // Category 
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');



    // Subcategory
    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/subcategories/{id}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');


    // brand 
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index'); // Hiển thị danh sách nhãn hàng
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create'); // Hiển thị form thêm mới nhãn hàng
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store'); // Lưu nhãn hàng mới
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit'); // Hiển thị form chỉnh sửa nhãn hàng
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update'); // Cập nhật nhãn hàng
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy'); // Xóa nhãn hàng



    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // ✅ AJAX route xóa nhanh (nếu cần gọi với ID cụ thể từ JavaScript)
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.ajax.destroy');
    // temp-images.create
    Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

    Route::get('/getSlug',function(Request $request){
        if(!empty($request->title)){
            $slug = Str::slug($request->title);
        }
        return response()->json([
            'status' => true,
            'slug' => $slug,
        ]);
    })->name('getSlug');

});
});