@extends('front.layout.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">Cart</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" id="cart">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(session('cart') && count(session('cart')) > 0)
                                @foreach(session('cart') as $id => $item)
                                    <tr data-id="{{ $id }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item['image'] ?? asset('uploads/product/thumb/default.jpg') }}" width="50" height="50" alt="{{ $item['name'] }}">
                                                <h2 class="ml-3">{{ $item['name'] }}</h2>
                                            </div>
                                        </td>
                                        <td>₫{{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1"
                                                        value="decrease"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="number"
                                                    class="form-control form-control-sm border-0 text-center"
                                                    name="quantity[{{ $id }}]"
                                                    value="{{ $item['quantity'] }}"
                                                    min="1"
                                                    max="{{ $item['qty'] ?? 1000 }}">
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1"
                                                        value="increase"
                                                        {{ isset($item['qty']) && $item['quantity'] >= $item['qty'] ? 'disabled' : '' }}>
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="item-total">
                                            ₫{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-remove" data-id="{{ $id }}"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button id="clear-cart-btn" class="btn btn-outline-danger mt-2">Xoá toàn bộ giỏ hàng</button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card cart-summery">
                    <div class="sub-title">
                        <h2 class="bg-white">Cart Summary</h2>
                    </div>
                    <div class="card-body">
                        @php
                            $total = 0;
                            $shipping = 20000;
                        @endphp
                        @foreach(session('cart', []) as $item)
                            @php $total += $item['quantity'] * $item['price']; @endphp
                        @endforeach

                        <div class="d-flex justify-content-between pb-2">
                            <div>Subtotal</div>
                            <div class="subtotal">₫{{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Shipping</div>
                            <div>₫{{ number_format($shipping, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex justify-content-between summery-end">
                            <div>Total</div>
                            <div class="grand-total">₫{{ number_format($total + $shipping, 0, ',', '.') }}</div>
                        </div>
                        <div class="pt-5">
                            <a href="{{ route('cart.checkout') }}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
                <div class="input-group apply-coupan mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control">
                    <button class="btn btn-dark" type="button">Apply Coupon</button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function () {
        // Cập nhật số lượng sản phẩm
        $('.btn-plus, .btn-minus').on('click', function (e) {
            e.preventDefault();
            let button = $(this);
            let action = button.val();  // 'increase' hoặc 'decrease'
            let row = button.closest('tr');
            let id = row.data('id');
            let input = row.find('input[type="number"]');
            let currentQuantity = parseInt(input.val());  // Số lượng hiện tại

            // Cập nhật số lượng
            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }

            // Gửi AJAX request để cập nhật giỏ hàng
            $.ajax({
                url: "{{ route('cart.update') }}", // Đảm bảo URL đúng
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // Đảm bảo CSRF token có trong request
                    action: action,
                    quantity: currentQuantity,  // Gửi số lượng đã thay đổi
                    id: id
                },
                success: function (res) {
                    if (res.status) {
                        input.val(res.quantity);  // Cập nhật lại ô input số lượng

                        // Cập nhật tổng tiền cho sản phẩm này
                        row.find('.item-total').text('₫' + res.itemTotal.toLocaleString('vi-VN'));

                        // Cập nhật tổng giỏ hàng và tổng tiền thanh toán
                        $('.subtotal').text('₫' + res.total.toLocaleString('vi-VN'));
                        $('.grand-total').text('₫' + res.grandTotal.toLocaleString('vi-VN'));
                    }
                }
            });
        });

        // Xóa sản phẩm khỏi giỏ hàng
        $('.btn-remove').on('click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
                $.ajax({
                    url: "{{ url('/cart/remove') }}/" + id,  // Route cần sửa
                    method: "GET",  // Phương thức GET
                    success: function (res) {
                        if (res.status) {
                            // Xóa dòng sản phẩm khỏi giỏ hàng
                            $(`tr[data-id="${id}"]`).remove();

                            // Cập nhật lại tổng giỏ hàng
                            $('.subtotal').text('₫' + res.total.toLocaleString('vi-VN'));
                            $('.grand-total').text('₫' + res.grandTotal.toLocaleString('vi-VN'));

                            // Cập nhật lại giỏ hàng trên giao diện nếu cần
                            console.log(res.cart);
                        }
                    }
                });
            }
        });

        // Xóa toàn bộ giỏ hàng
        $('#clear-cart-btn').on('click', function () {
            if (confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?")) {
                $.ajax({
                    url: "{{ route('cart.clear') }}",
                    method: "POST",  // Đảm bảo phương thức là POST
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.status) {
                            $('#cart tbody').empty();  // Xóa tất cả các sản phẩm trong giỏ
                            $('.subtotal').text('₫0');
                            $('.grand-total').text('₫0');
                            $('#cart-count').text('0');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
