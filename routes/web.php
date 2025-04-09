<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\Adminlogincontroller;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\TempImagesController;
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