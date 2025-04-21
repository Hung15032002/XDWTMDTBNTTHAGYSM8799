<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

use Intervention\Image\Image;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::latest();

        if(!empty($request->get('keyword')))
        {
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }
        
        $categories = $categories->paginate(10);
        
        return view('admin.category.list',compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request )
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if($validator->passes()){
        
           $category = new Category();
           $category->name = $request->name;
           $category->slug = $request->slug;
           $category->status = $request->status;
           $category->save();


           //luu anh 
           if(!empty($request->image_id))
           {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.',$tempImage->name);
            $ext = last($extArray);

            $newImageName = $category->id.'.'.$ext;
            $sPath = public_path().'/temp/'.$tempImage->name;
            $dPath = public_path().'/uploads/category/'.$tempImage->name;
           
            File::copy($sPath,$dPath);

            $dPath = public_path().'/uploads/category/thumb/'.$newImageName;

            $manager = new ImageManager(new Driver());
            $img = $manager->read($sPath)->resize(500, 500);
            
            $encoded = $img->encode(new JpegEncoder());
            file_put_contents($dPath, $encoded);

            $category->image = $newImageName;   
            $category->save();

           }

           $request->session()->flash('Them loai san pham thanh cong !');
           session()->flash('success', 'Thao tác thành công!');
           return response()->json([
            'status' => true,
            'message' => 'Them loai san pham thanh cong !',
        ]);

        } else {
            session()->flash('error', 'Đã có lỗi xảy ra!');
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
          
        }
    }
    public function edit($categoryId , Request  $request)
    {
        $category = Category::find($categoryId);
        if(empty($category))
        {
            return redirect()->route('categories.index');
        }
        return view('admin.category.edit',compact('category')); 
    }
    public function update($categoryId , Request $request)
    {

        $category = Category::find($categoryId);
        if(empty($category))
        {
            return response()->json([
                'status' => false,
                'notFound'=> true,
                'message' => 'Khong tim thay danh muc !'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
        ]);

        if($validator->passes()){
        
           $category->name = $request->name;
           $category->slug = $request->slug;
           $category->status = $request->status;
           $category->save();

           $oldImage = $category->image;

           //luu anh 
           if(!empty($request->image_id))
           {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.',$tempImage->name);
            $ext = last($extArray);

            $newImageName = $category->id.'.'.$ext;
            $sPath = public_path().'/temp/'.$tempImage->name;
            $dPath = public_path().'/uploads/category/'.$tempImage->name;
           
            File::copy($sPath,$dPath);

            $dPath = public_path().'/uploads/category/thumb/'.$newImageName;

            $manager = new ImageManager(new Driver());
            // $img = $manager->read($sPath)->resize(500, 500);
               $img = $manager->read($sPath)->scaleDown(500, 500);
            
            $encoded = $img->encode(new JpegEncoder());
            file_put_contents($dPath, $encoded);

            $category->image = $newImageName;   
            $category->save();

            if ($oldImage && $oldImage != $category->image) {
                File::delete(public_path('uploads/category/' . $oldImage));
                File::delete(public_path('uploads/category/thumb/' . $oldImage));
            }

           }

           $request->session()->flash('Cap nhat san pham thanh cong !');
           session()->flash('success', 'Thao tác thành công!');
           return response()->json([
            'status' => true,
            'message' => 'Cap nhat  san pham thanh cong !',
        ]);

        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            session()->flash('error', 'Đã có lỗi xảy ra!');
        }
    }
   public function destroy($id)
{
    $category = Category::find($id);
    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy danh mục!'
        ]);
    }

    // Nếu có ảnh thì xóa luôn
    if ($category->image) {
        $imagePath = public_path('uploads/category/' . $category->image);
        $thumbPath = public_path('uploads/category/thumb/' . $category->image);
        if (File::exists($imagePath)) File::delete($imagePath);
        if (File::exists($thumbPath)) File::delete($thumbPath);
    }

    $category->delete();

    return response()->json([
        'status' => true,
        'message' => 'Xóa danh mục thành công!'
    ]);
}
}
