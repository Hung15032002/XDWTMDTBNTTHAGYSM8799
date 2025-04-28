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
    
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();
    
        $products = Product::with('subcategory.category')
            ->where('products.status', 1)
            ->whereHas('subcategory', function ($query) {
                $query->where('status', 1)
                      ->whereHas('category', function ($q) {
                          $q->where('status', 1);
                      });
            })
            ->whereHas('brand', function ($query) {
                $query->where('status', 1);
            });
    
        // Các bộ lọc khác (brand, subcategory, price)
        if ($request->filled('brand')) {
            $products->whereIn('brand_id', $request->brand);
        }
    
        if ($request->filled('subcategory')) {
            $products->whereIn('subcategory_id', $request->subcategory);
        }
    
        if ($request->filled('price')) {
            $products->where(function($query) use ($request) {
                foreach ($request->price as $priceRange) {
                    if (strpos($priceRange, '+') !== false) {
                        $min = (int) rtrim($priceRange, '+');
                        $query->orWhere('price', '>=', $min);
                    } else {
                        [$min, $max] = explode('-', $priceRange);
                        $query->orWhereBetween('price', [(int)$min, (int)$max]);
                    }
                }
            });
        }
    
        // Sắp xếp
        if ($sort === 'price_asc') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $products->orderBy('price', 'desc');
        } else {
            $products->orderBy('created_at', 'desc');
        }
    
        $products = $products->paginate(12);
        $products->appends($request->all());
    
        return view('front.shop', compact('categories', 'brands', 'subcategories', 'products'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $category->id)
            ->where('status', 1)
            ->paginate(12);

        return view('front.category', compact('category', 'products'));
    }
}
