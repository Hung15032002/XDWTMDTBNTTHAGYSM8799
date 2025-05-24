<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;   
use App\Models\Transaction;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = Order::count();
    $totalProducts = Product::count();

    $latestTransaction = Transaction::orderBy('transaction_date', 'desc')->first();
    $currentBalance = $latestTransaction ? $latestTransaction->balance : '0 VND';

    return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'currentBalance'));
    }
    public function logout(){
      Auth::guard('admin')->logout();
      return redirect()->route('admin.login');
  }
}

