<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function showCart()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $cart = session()->get('cart', []);

        return view('front.cart', compact('categories', 'subcategories', 'cart'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        $quantityToAdd = isset($data['quantity']) && is_numeric($data['quantity']) ? (int)$data['quantity'] : 1;

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại.'], 404);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + $quantityToAdd <= $product->qty) {
                $cart[$id]['quantity'] += $quantityToAdd;
            } else {
                return response()->json(['error' => 'Không thể thêm quá số lượng tồn kho!', 'maxQty' => $product->qty], 400);
            }
        } else {
            $cart[$id] = [
                'name' => $product->title,
                'quantity' => $quantityToAdd,
                'price' => $product->price,
                'image' => $product->image ? asset('uploads/product/thumb/' . $product->image) : null,
                'qty' => $product->qty,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => 'Sản phẩm đã được thêm vào giỏ hàng!',
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

        if (!isset($cart[$id])) {
            return response()->json(['status' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng']);
        }

        $item = &$cart[$id];
        $maxQty = $item['qty'];

        switch ($request->action) {
            case 'increase':
                if ($item['quantity'] < $maxQty) {
                    $item['quantity']++;
                } else {
                    return response()->json(['status' => false, 'message' => 'Đã đạt giới hạn tồn kho', 'quantity' => $item['quantity'], 'maxQty' => $maxQty]);
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
        $grandTotal = $total + 20000;

        return response()->json([
            'status' => true,
            'quantity' => $item['quantity'],
            'itemTotal' => $itemTotal,
            'total' => $total,
            'grandTotal' => $grandTotal,
            'maxQty' => $maxQty,
        ]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $total = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);
        $grandTotal = $total + 20000;

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
        return view('checkout');
    }
}
