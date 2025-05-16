<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        // Lấy danh mục sản phẩm và giỏ hàng
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $cart = session('cart', []);

        // Kiểm tra nếu giỏ hàng trống, chuyển hướng về trang shop
        if (empty($cart)) {
            return redirect()->route('front.shop')->with('error', 'Giỏ hàng của bạn trống!');
        }

        return view('front.checkout', compact('categories', 'subcategories', 'cart'));
    }

    public function processCheckout(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'name'           => 'required|string',
        'email'          => 'required|email',
        'phone'          => 'required|string',
        'address'        => 'required|string',
        'payment_method' => 'required|in:cod,bank',  // Chỉ hỗ trợ hai phương thức thanh toán 'cod' và 'bank'
    ]);

    $cart = session('cart', []);
    if (empty($cart)) {
        return redirect()->route('front.shop')->with('error', 'Giỏ hàng của bạn trống!');
    }

    // Tính tổng tiền đơn hàng
    $total = collect($cart)->reduce(function ($carry, $item) {
        return $carry + ($item['quantity'] * $item['price']);
    }, 0);

    // Tính tiền đặt cọc nếu phương thức thanh toán là 'cod'
    $deposit = $request->payment_method === 'cod' ? round($total * 0.05) : 0;

    // Lưu thông tin đơn hàng vào database
    $order = Order::create([
        'name'           => $request->name,
        'email'          => $request->email,
        'phone'          => $request->phone,
        'address'        => $request->address,
        'payment_method' => $request->payment_method,
        'total'          => $total,
        'deposit'        => $deposit,
        'ordered_at'     => Carbon::now(),
        'status'         => 'pending',  // Trạng thái đơn hàng ban đầu là 'pending'
    ]);

    // Lưu các sản phẩm trong giỏ vào bảng OrderItem
    foreach ($cart as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'name'     => $item['name'],
            'quantity' => $item['quantity'],
            'price'    => $item['price'],
        ]);
    }

    // Xóa giỏ hàng sau khi đặt hàng thành công
    session()->forget('cart');

    // Tạo thông báo sau khi thanh toán thành công
    $message = 'Đặt hàng thành công! ';

    if ($request->payment_method === 'cod') {
        $message .= 'Vui lòng chuyển khoản đặt cọc 5% (' . number_format($deposit, 0, ',', '.') . ' VNĐ). ';
    } else {
        $message .= 'Vui lòng chuyển khoản toàn bộ số tiền (' . number_format($total, 0, ',', '.') . ' VNĐ). ';
    }

    $message .= 'Với nội dung chuyển khoản là  : Họ và Tên +  Số điện thoại . Chúng tôi sẽ liên hệ với bạn trong ít phút để hoàn tất giao dịch.';

    // Chuyển hướng đến trang thông báo thanh toán thành công và truyền thông báo qua session
    return redirect()->route('payment.success')->with('success_message', $message);
}

    // Phương thức hiển thị thông báo thanh toán thành công
    public function showPaymentSuccess()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
       
        $message = session('success_message');

        // Trả về view thanh toán thành công và truyền thông báo qua session
        return view('front.payment', compact('categories', 'subcategories', 'message'));
    }



}

