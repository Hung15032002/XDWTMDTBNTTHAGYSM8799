<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Brand;       // Thêm import Brand
use App\Models\Category;    // Thêm import Category
use App\Models\Subcategory; // Thêm import Subcategory

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        // Thêm các thống kê mới
        $totalBrands = Brand::count();
        $totalCategories = Category::count();
        $totalSubcategories = Subcategory::count();

        $latestTransaction = Transaction::orderBy('transaction_date', 'desc')->first();
        $currentBalance = $latestTransaction ? $latestTransaction->balance : '0 VND';

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalBrands',
            'totalCategories',
            'totalSubcategories',
            'currentBalance'
        ));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
