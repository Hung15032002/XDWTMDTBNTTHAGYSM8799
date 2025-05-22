<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Page; // nhớ thêm dòng này ở đầu file


class FrontController extends Controller
{
    public function index(Request $request)
    {
        // Lấy danh mục cha
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
    
        // Lấy loại sản phẩm con (subcategories)
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();
    
        // Lấy sản phẩm mới nhất
        $products = Product::where('products.status', 1)
            ->whereHas('subcategory', function($query) {
                $query->where('status', 1)
                    ->whereHas('category', function($q) {
                        $q->where('status', 1);
                    });
            })
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();
    
        // 👉 Lấy thông tin liên hệ
        $page = Page::first(); // nếu bạn có nhiều page, dùng where('type', ...) hoặc theo id cụ thể
    
        // Truyền thêm page sang view
        return view('front.home', compact('categories', 'subcategories', 'products', 'page'));
    }
    public function getProductsBySubcategory($id)
{
    $products = Product::where('products.status', 1)
        ->where('subcategory_id', $id) // 👈 thêm dòng này
        ->whereHas('subcategory', function($query) {
            $query->where('status', 1)
                  ->whereHas('category', function($q) {
                      $q->where('status', 1);
                  });
        })
        ->orderBy('created_at', 'DESC')
        ->take(10)
        ->get();

    return response()->json(['products' => $products]);
}

}
