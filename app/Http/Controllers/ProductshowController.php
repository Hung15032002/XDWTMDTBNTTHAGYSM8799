<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class ProductshowController extends Controller
{
    // Trang danh sách sản phẩm (trang chủ)
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();

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

        return view('front.home', compact('categories', 'subcategories', 'products'));
    }

    // Trang chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['subcategory.category', 'brand'])
                        ->where('id', $id)
                        ->where('status', 1)
                        ->firstOrFail();

        $product->images = $product->image ? explode(',', $product->image) : [];

        if (empty($product->images)) {
            return redirect()->back()->with('error', 'No images found for this product.');
        }

        // Sản phẩm liên quan (cùng subcategory)
        $relatedProducts = Product::where('subcategory_id', $product->subcategory_id)
            ->where('id', '!=', $product->id)
            ->take(5)
            ->get();

        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();

        // Gợi ý sản phẩm theo category (khác subcategory và khác sản phẩm hiện tại)
        $categoryId = $product->subcategory->category_id;

        $recommendedProducts = Product::whereHas('subcategory', function($query) use ($categoryId, $product) {
                $query->where('category_id', $categoryId)
                      ->where('id', '!=', $product->subcategory_id);
            })
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(5)
            ->get();

        return view('front.productshow', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
