<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class ProductshowController extends Controller
{
    public function index(Request $request)
    {

        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('front.productshow', compact('categories', 'brands', 'subcategories',));

    }
}
