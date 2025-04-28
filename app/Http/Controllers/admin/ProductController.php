<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Subcategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest();

        if ($request->filled('keyword')) {
            $products->where('name', 'like', '%' . $request->keyword . '%');
        }

        return view('admin.product.list', [
            'products' => $products->paginate(10)
        ]);
    }

    public function create()
    {
        $tempImages = TempImage::latest()->get();
        $brands = Brand::all();
        $subcategories = Subcategory::all();
        return view('admin.product.create', compact('tempImages', 'brands', 'subcategories'));
    }

    public function store(Request $request)
    {
        return $this->saveProduct(new Product(), $request);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        $subcategories = Subcategory::all();
        return view('admin.product.edit', compact('product', 'brands', 'subcategories'));
    }

    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        return $this->saveProduct($product, $request, true);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy sản phẩm!']);
        }

        $this->deleteProductImages($product);
        $product->delete();

        return response()->json(['status' => true, 'message' => 'Xóa sản phẩm thành công!']);
    }

    // ================================
    // 🔧 HÀM DÙNG CHUNG
    // ================================

    private function saveProduct(Product $product, Request $request, $isUpdate = false)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required|unique:products,slug' . ($isUpdate ? ',' . $product->id : ''),
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'code' => 'required|unique:products,code' . ($isUpdate ? ',' . $product->id : ''),
            'brand_id' => 'nullable|exists:brands,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $product->fill($request->only([
            'name', 'slug', 'price', 'qty', 'code', 'description', 'status',
            'brand_id', 'subcategory_id'
        ]));

        $product->save();

        $this->handleImageUpload($product, $request, $isUpdate);

        return response()->json([
            'status' => true,
            'message' => $isUpdate ? 'Cập nhật sản phẩm thành công!' : 'Thêm sản phẩm thành công!',
        ]);
    }

    private function handleImageUpload($product, $request, $isUpdate = false)
    {
        $imageIds = $request->input('image_id');
        if (!$imageIds) return;

        $ids = is_array($imageIds) ? $imageIds : explode(',', $imageIds);

        foreach ($ids as $imageId) {
            $tempImage = TempImage::find($imageId);
            if (!$tempImage) continue;

            $ext = pathinfo($tempImage->name, PATHINFO_EXTENSION);
            $newImageName = $product->id . '_' . uniqid() . '.' . $ext;

            $sourcePath = public_path('temp/' . $tempImage->name);
            $destPath = public_path('uploads/product/' . $newImageName);
            $thumbPath = public_path('uploads/product/thumb/' . $newImageName);

            if (!File::exists(public_path('uploads/product/'))) {
                File::makeDirectory(public_path('uploads/product/'), 0777, true);
            }

            if (!File::exists(public_path('uploads/product/thumb/'))) {
                File::makeDirectory(public_path('uploads/product/thumb/'), 0777, true);
            }

            File::copy($sourcePath, $destPath);

            $manager = new ImageManager(new Driver());
            $image = $manager->read($sourcePath)->scale(500, 500);
            $encoded = $image->encode(new JpegEncoder());
            file_put_contents($thumbPath, $encoded);

            // Nếu đang update thì xóa ảnh cũ
            if ($isUpdate && $product->image && File::exists(public_path('uploads/product/' . $product->image))) {
                File::delete(public_path('uploads/product/' . $product->image));
                File::delete(public_path('uploads/product/thumb/' . $product->image));
            }

            $product->image = $newImageName;
            $product->save();

            File::delete($sourcePath);
            $tempImage->delete();

            break; // Chỉ lưu 1 ảnh
        }
    }

    private function deleteProductImages(Product $product)
    {
        if ($product->image) {
            File::delete(public_path('uploads/product/' . $product->image));
            File::delete(public_path('uploads/product/thumb/' . $product->image));
        }
    }
    
    
}
