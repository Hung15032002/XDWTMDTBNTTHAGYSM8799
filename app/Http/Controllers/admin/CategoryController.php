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

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            session()->flash('error', 'Đã có lỗi xảy ra!');
        }
    }
    public function edit($categoryId , Request  $request)
    {
        return view('admin.category.edit');
    }
    public function update()
    {
        
    }
    public function destroy()
    {
        
    }
}
