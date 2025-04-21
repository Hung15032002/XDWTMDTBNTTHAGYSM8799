<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query();

        if ($request->filled('keyword')) {
            $brands = $brands->where('name', 'like', '%' . $request->keyword . '%');
        }

        $brands = $brands->paginate(10);

        return view('admin.brand.list', compact('brands'));
    }

    // Hiển thị form tạo mới nhãn hàng
    public function create()
    {
        return view('admin.brand.create');
    }

    // Lưu nhãn hàng mới
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'status' => 'required|boolean',
        ]);
        
        try {
            // Tạo slug từ tên nếu chưa có slug
            $slug = $request->slug ?: Str::slug($request->name);
    
            // Lưu dữ liệu
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $slug;
            $brand->status = $request->status;
            $brand->save();
    
            // Trả về JSON response để AJAX xử lý
            return response()->json([
                'status' => true
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi, trả về thông báo lỗi cho AJAX
            return response()->json([
                'status' => false,
                'errors' => [
                    'name' => 'Có lỗi xảy ra khi lưu nhãn hàng.',
                    'slug' => 'Slug không hợp lệ.',
                ]
            ]);
        }
    }
    
    // Hiển thị form chỉnh sửa nhãn hàng
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    // Cập nhật nhãn hàng
    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $id,
            'status' => 'required|boolean',
        ]);
    
        try {
            // Tạo slug từ tên nếu chưa có slug
            $slug = $request->slug ?: Str::slug($request->name);

            // Cập nhật dữ liệu
            $brand = Brand::findOrFail($id);
            $brand->name = $request->name;
            $brand->slug = $slug;
            $brand->status = $request->status;
            $brand->save();
    
            // Flash message thành công
            session()->flash('success', 'Nhãn hàng đã được cập nhật thành công!');
            
            return redirect()->route('brands.index');  // Chuyển về trang danh sách nhãn hàng
        } catch (\Exception $e) {
            // Flash message lỗi nếu có sự cố khi cập nhật
            session()->flash('error', 'Có lỗi xảy ra khi cập nhật nhãn hàng. Vui lòng thử lại!');
            
            return redirect()->back();  // Quay lại trang hiện tại
        }
    }

    // Xóa nhãn hàng
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            
            // Trả về JSON response khi xóa thành công
            return response()->json([
                'status' => true,
                'message' => 'Nhãn hàng đã được xóa thành công!'
            ]);
        } catch (\Exception $e) {
            // Trả về JSON response nếu có lỗi
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi xóa nhãn hàng.'
            ]);
        }
    }
}

