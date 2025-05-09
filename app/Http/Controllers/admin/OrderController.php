<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Order::with('orderItems')->orderByDesc('created_at');

        // Tìm kiếm theo tên, email hoặc ID
        if ($search = $request->input('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($status = $request->input('status')) {
            $query->where('status', $status);  // Trạng thái đang dùng trong CSDL
        }

        $orders = $query->paginate(10);
        return view('admin.order.list', compact('orders'));
    }

    /**
     * Hiển thị chi tiết đơn hàng.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);

        // Xác nhận đơn hàng
        if ($request->has('confirm')) {
            $order->status = 'da_xac_nhan';
            $message = '✅ Đơn hàng đã được xác nhận!';
        }
        // Đang vận chuyển
        elseif ($request->has('shipping')) {
            $order->status = 'dang_van_chuyen';
            $message = '🚚 Đơn hàng đang được vận chuyển!';
        }
        // Hoàn thành
        elseif ($request->has('complete')) {
            $order->status = 'hoan_thanh';
            $message = '🎉 Đơn hàng đã hoàn thành!';
        }
        // Hủy đơn hàng
        elseif ($request->has('cancel')) {
            $order->status = 'huy';
            $message = '❌ Đơn hàng đã bị hủy!';
        }
        // Trạng thái không hợp lệ
        else {
            return redirect()->route('admin.order.list')->with('error', 'Trạng thái không hợp lệ!');
        }

        // Lưu lại thay đổi và trả về thông báo
        $order->save();

        return redirect()->route('admin.order.list')->with('success', $message);
    }

    /**
     * Hiển thị form chỉnh sửa đơn hàng.
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function edit(Order $order)
    {
        return view('admin.order.edit', compact('order'));
    }

    /**
     * Cập nhật thông tin đơn hàng sau khi chỉnh sửa.
     *
     * @param \Illuminate\Http\Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        // Validate dữ liệu (nếu cần)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'status' => 'required|string',
            // 'total' => 'required|numeric',
            // 'ordered_at' => 'required|date',
        ]);

        // Cập nhật thông tin đơn hàng
        $order->update($request->all());

        // Quay lại trang danh sách đơn hàng với thông báo
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được cập nhật');
    }

    /**
     * Xóa đơn hàng.
     *
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Order $order)
    {
        // Xóa đơn hàng
        $order->delete();

        // Quay lại trang danh sách đơn hàng với thông báo
        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã bị xóa');
    }
}
