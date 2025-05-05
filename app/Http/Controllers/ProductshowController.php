<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;

class ProductshowController extends Controller
{
    // Phương thức này xử lý trang danh sách sản phẩm hoặc trang lọc sản phẩm
    public function index(Request $request)
    {
        // Lấy danh mục cha
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        // Lấy loại sản phẩm con (subcategories)
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();

        // Lấy sản phẩm mới nhất:
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

    // Phương thức này xử lý việc hiển thị chi tiết sản phẩm
    public function show($id)
    {
        // Lấy sản phẩm với các mối quan hệ category, subcategory và brand
        $product = Product::with(['subcategory.category', 'brand'])
                        ->where('id', $id)
                        ->where('status', 1)
                        ->firstOrFail();
        
        // Kiểm tra nếu trường image không rỗng
        if ($product->image) {
            // Nếu cần, có thể chuyển chuỗi thành mảng nếu bạn lưu nhiều ảnh trong trường 'image' (dùng dấu phẩy phân tách)
            $product->images = explode(',', $product->image);
        } else {
            $product->images = []; // Nếu không có ảnh, khởi tạo mảng rỗng
        }

        // Kiểm tra xem có hình ảnh trong mảng không
        if (empty($product->images)) {
            return redirect()->back()->with('error', 'No images found for this product.');
        }

        // Lấy các sản phẩm liên quan dựa trên subcategory của sản phẩm hiện tại
        $relatedProducts = Product::where('subcategory_id', $product->subcategory_id)
            ->where('id', '!=', $product->id)
            ->take(5)
            ->get();  
        
        // Lấy danh mục cha và loại sản phẩm con để truyền vào view
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $subcategories = Subcategory::where('status', 1)->orderBy('name', 'ASC')->get();
        
        // Trả về view với dữ liệu sản phẩm, sản phẩm liên quan, các danh mục và loại sản phẩm con
        return view('front.productshow', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }



    
}
