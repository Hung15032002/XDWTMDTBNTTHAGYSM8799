<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', null);

        // Lấy tất cả danh mục, thương hiệu và danh mục con
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();

        // Query sản phẩm
        $products = Product::select('products.*')
            ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.status', 1)
            ->where('subcategories.status', 1)
            ->where('categories.status', 1)
            ->where('brands.status', 1);

        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $products->whereIn('products.brand_id', $request->brand);
        }

        // Lọc theo danh mục con
        if ($request->filled('subcategory')) {
            $products->whereIn('products.subcategory_id', $request->subcategory);
        }

        // Lọc theo khoảng giá
        if ($request->filled('price')) {
            $products->where(function ($query) use ($request) {
                foreach ($request->price as $priceRange) {
                    if (strpos($priceRange, '+') !== false) {
                        $min = (int) rtrim($priceRange, '+');
                        $query->orWhere('products.price', '>=', $min);
                    } else {
                        [$min, $max] = explode('-', $priceRange);
                        $query->orWhereBetween('products.price', [(int)$min, (int)$max]);
                    }
                }
            });
        }

        // Sắp xếp
        if ($sort === 'price_asc') {
            $products->orderBy('products.price', 'asc');
        } elseif ($sort === 'price_desc') {
            $products->orderBy('products.price', 'desc');
        } else {
            $products->orderBy('products.created_at', 'desc');
        }

        // Phân trang
        $products = $products->paginate(12);
        $products->appends($request->all());

        return view('front.shop', compact('categories', 'brands', 'subcategories', 'products'));
    }

    // Hiển thị sản phẩm theo danh mục
    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->paginate(12);

        return view('front.category', compact('category', 'products'));
    }
}
