<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function showCart()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $cart = session()->get('cart', []); // Giỏ hàng

        return view('front.cart', compact('categories', 'subcategories', 'cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id, Request $request)
    {
        $product = Product::find($id);  // Truy vấn sản phẩm từ cơ sở dữ liệu
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại.'], 400);
        }
    
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);
    
        // Tạo đường dẫn ảnh đầy đủ
        $imageUrl = $product->image 
            ? asset('uploads/product/thumb/' . $product->image)
            : asset('uploads/product/thumb/default.jpg');
    
        // Lấy số lượng tồn kho tối đa của sản phẩm từ cơ sở dữ liệu
        $maxQty = $product->qty; // Thay vì $product->quantity, dùng $product->qty

        if (isset($cart[$id])) {
            // Kiểm tra nếu số lượng trong giỏ hàng vượt quá số lượng tồn kho
            if ($cart[$id]['quantity'] + $quantity <= $maxQty) {
                $cart[$id]['quantity'] += $quantity;
            } else {
                return response()->json(['error' => 'Số lượng yêu cầu vượt quá số lượng tồn kho.'], 400);
            }
        } else {
            if ($quantity <= $maxQty) {
                $cart[$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'image' => $imageUrl,
                ];
            } else {
                return response()->json(['error' => 'Số lượng yêu cầu vượt quá số lượng tồn kho.'], 400);
            }
        }
    
        session()->put('cart', $cart);
    
        return response()->json([
            'success' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cartCount' => count($cart),
        ]);
    }

    // Cập nhật giỏ hàng
    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required|in:increase,decrease,update',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->id;
        $product = Product::find($id);  // Truy vấn sản phẩm từ cơ sở dữ liệu
        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Sản phẩm không tồn tại']);
        }

        // Kiểm tra xem sản phẩm có trong giỏ hàng không
        if (!isset($cart[$id])) {
            return response()->json(['status' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
        }

        $item = &$cart[$id];
        $maxQty = $product->qty;  // Lấy số lượng tồn kho thực tế từ cơ sở dữ liệu

        // Cập nhật giỏ hàng theo hành động
        switch ($request->action) {
            case 'increase':
                if ($item['quantity'] < $maxQty) {
                    $item['quantity']++;
                } else {
                    return response()->json(['status' => false, 'message' => 'Đã đạt giới hạn tồn kho']);
                }
                break;

            case 'decrease':
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                }
                break;

            case 'update':
                $newQty = (int) $request->quantity;
                $item['quantity'] = max(1, min($newQty, $maxQty));
                break;
        }

        session()->put('cart', $cart);

        $itemTotal = $item['quantity'] * $item['price'];
        $total = collect($cart)->sum(fn($i) => $i['quantity'] * $i['price']);
        $grandTotal = $total ; // Phí vận chuyển tạm tính

        return response()->json([
            'status' => true,
            'quantity' => $item['quantity'],
            'itemTotal' => $itemTotal,
            'total' => $total,
            'grandTotal' => $grandTotal,
        ]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        // Kiểm tra xem sản phẩm có trong giỏ không
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);
        $grandTotal = $total + 0; // Phí vận chuyển tạm tính

        return response()->json([
            'status' => true,
            'cart' => array_values($cart),
            'total' => $total,
            'grandTotal' => $grandTotal
        ]);
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'status' => true,
            'cart' => [],
            'total' => 0,
            'grandTotal' => 0
        ]);
    }

    // Trang thanh toán
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('front.shop')->with('error', 'Giỏ hàng của bạn trống!');
        }

        return view('checkout');
    }
}
