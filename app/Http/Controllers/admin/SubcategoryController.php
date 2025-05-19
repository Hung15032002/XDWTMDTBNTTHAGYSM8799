<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{

    public function index(Request $request)
{
    // Truy vấn cơ bản với việc kết nối bảng categories
    $subCategories = Subcategory::select('subcategories.*', 'categories.name as categoryName')
        ->latest('id')
        ->leftJoin('categories', 'categories.id', '=', 'subcategories.category_id');
    
    // Xử lý tìm kiếm nếu có từ khóa
    if (!empty($request->get('keyword'))) {
        $keyword = $request->get('keyword');
        $subCategories = $subCategories->where(function($query) use ($keyword) {
            $query->where('subcategories.name', 'like', '%' . $keyword . '%')
                  ->orWhere('subcategories.slug', 'like', '%' . $keyword . '%')
                  ->orWhere('categories.name', 'like', '%' . $keyword . '%'); // Tìm kiếm theo tên danh mục
        });
    }

    // Phân trang kết quả
    $subCategories = $subCategories->paginate(20);

    // Trả về view với dữ liệu
    return view('admin.subcategory.list', compact('subCategories'));
}

    public function create()
{
    $categories = Category::orderBy('name', 'ASC')->get();
    $data['categories'] = $categories;
    return view('admin.subcategory.create', $data);
}
    public function store (Request $request){
       $validator = Validator::make($request->all(),[
        'name' => 'required',
        'slug' => 'required|unique:subcategories',
        'category_id' => 'required',
        'status' => 'required',
       ]);

       if($validator->passes())
       {
        $subCategory = new Subcategory();
        $subCategory->name = $request->name;
        $subCategory->slug = $request->slug;
        $subCategory->status = $request->status;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();

        $request->session()->flash('Thêm mới loại sản phẩm thành công ! ');

       return response([
            'status' => true,
            'message'=> 'Thêm mới loại sản phẩm thành công!',
            'redirect_url' => route('subcategories.index')
        ]);
       } else{
        return response([
            'status' => false,
            'errors' => $validator->errors()
        ]);
       }
    }
    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $categories = Category::all(); // để chọn danh mục cha
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean'
        ]);

        $subcategory = Subcategory::findOrFail($id);
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->category_id = $request->category_id;
        $subcategory->status = $request->status;
        $subcategory->save();

        return redirect()->route('subcategories.index')->with('success', 'Cập nhật thành công!');
    }

    // Xóa dữ liệu
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
            return response()->json([
                'status' => true,
                'message' => 'Đã xóa thành công.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy loại sản phẩm.'
        ]);
    }
}
