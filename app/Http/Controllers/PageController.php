<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Hiển thị danh sách các thông tin liên hệ
    public function index(Request $request)
    {
        $pages = Page::all();  // Lấy tất cả các thông tin cài đặt
        return view('admin.page.list', compact('pages'));
    }

    // Hiển thị form chỉnh sửa thông tin cài đặt
    public function edit($id)
    {
        // Lấy thông tin cài đặt từ bảng Page theo ID
        $page = Page::findOrFail($id);
        return view('admin.page.edit', compact('page')); // Trả về view edit
    }

    // Cập nhật thông tin cài đặt
    // Cập nhật thông tin cài đặt
    public function update(Request $request, $id)
    {
        // Validation cho form
        $request->validate([
            'facebook_link' => 'nullable|url',
            'zalo_link' => 'nullable|url',
            'address' => 'nullable|string|max:255',
            'phone_numbers' => 'nullable|array',
            'phone_numbers.*' => 'nullable|string', // Tùy chỉnh quy tắc kiểm tra số điện thoại
        ]);

        // Tìm bản ghi cài đặt theo ID
        $page = Page::findOrFail($id);

        // Cập nhật thông tin trong bảng page
        $page->facebook_link = $request->facebook_link;
        $page->zalo_link = $request->zalo_link;
        $page->address = $request->address;
        $page->phone_numbers = json_encode($request->phone_numbers); // Lưu dưới dạng JSON
        $page->save();

        // Sau khi cập nhật thành công, quay về trang danh sách
        return redirect()->route('pages.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    // Lưu thông tin mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Validation cho form
        $request->validate([
            'facebook_link' => 'nullable|url',
            'zalo_link' => 'nullable|url',
            'address' => 'nullable|string|max:255',
            'phone_numbers' => 'nullable|array',
            'phone_numbers.*' => 'nullable|string', // Tùy chỉnh quy tắc kiểm tra số điện thoại
        ]);

        // Tạo mới thông tin
        $page = new Page();
        $page->facebook_link = $request->facebook_link;
        $page->zalo_link = $request->zalo_link;
        $page->address = $request->address;
        $page->phone_numbers = json_encode($request->phone_numbers); // Lưu dưới dạng JSON
        $page->save();

        // Redirect đến trang chỉnh sửa sau khi lưu thông tin mới
        return redirect()->route('pages.edit', $page->id)->with('success', 'Thêm mới thông tin thành công!');
    }

    // Xóa thông tin liên hệ
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        // Redirect về danh sách thông tin liên hệ sau khi xóa thành công
        return redirect()->route('pages.index')->with('success', 'Xóa thông tin thành công!');
    }
    public function create()
    {
        return view('admin.page.create'); // hoặc view tương ứng bạn đang dùng
    }
}
