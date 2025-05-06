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
                                <th>Sản Phẩm</th>
                                <th>Giá</th>
                                <th>Số Lượng</th>
                                <th>Tổng Giá</th>
                                <th>Xóa</th>
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
                                        <td>{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
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
                                            {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }} VNĐ
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
                            $shipping = 0; // miễn phí vận chuyển
                        @endphp
                        @foreach(session('cart', []) as $item)
                            @php $total += $item['quantity'] * $item['price']; @endphp
                        @endforeach

                        <div class="d-flex justify-content-between pb-2">
                            <div>Tổng Toàn Bộ Hóa Đơn</div>
                            <div class="subtotal">{{ number_format($total, 0, ',', '.') }} VNĐ</div>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Phí Vận Chuyển</div>
                            <div>{{ number_format($shipping, 0, ',', '.') }} VNĐ</div>
                        </div>
                        <div class="d-flex justify-content-between summery-end">
                            <div>Hóa Đơn Cuối</div>
                            <div class="grand-total">{{ number_format($total + $shipping, 0, ',', '.') }} VNĐ</div>
                        </div>
                        <div class="pt-5">
                            <a href="{{ route('checkout.show') }}" class="btn btn-dark">Thanh Toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateButtonStates(row) {
        let input = row.find('input[type="number"]');
        let quantity = parseInt(input.val());
        let maxQty = parseInt(input.attr('max')) || 1000;

        row.find('.btn-minus').prop('disabled', quantity <= 1);
        row.find('.btn-plus').prop('disabled', quantity >= maxQty);
    }

    $(function () {
        $('#cart tbody tr').each(function () {
            updateButtonStates($(this));
        });

        $('.btn-plus, .btn-minus').on('click', function (e) {
            e.preventDefault();
            let button = $(this);
            let action = button.val();
            let row = button.closest('tr');
            let id = row.data('id');
            let input = row.find('input[type="number"]');
            let currentQuantity = parseInt(input.val());
            let maxQty = parseInt(input.attr('max')) || 1000;

            if (action === 'increase' && currentQuantity >= maxQty) return;
            if (action === 'decrease' && currentQuantity <= 1) return;

            if (action === 'increase') currentQuantity++;
            if (action === 'decrease') currentQuantity--;

            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    action: action,
                    quantity: currentQuantity,
                    id: id
                },
                success: function (res) {
                    if (res.status) {
                        input.val(res.quantity);
                        row.find('.item-total').text(res.itemTotal.toLocaleString('vi-VN') + ' VNĐ');
                        $('.subtotal').text(res.total.toLocaleString('vi-VN') + ' VNĐ');
                        $('.grand-total').text(res.grandTotal.toLocaleString('vi-VN') + ' VNĐ');
                        updateButtonStates(row);
                    } else if (res.message) {
                        alert(res.message);
                    }
                }
            });
        });

        $('.btn-remove').on('click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?")) {
                $.ajax({
                    url: "{{ url('/cart/remove') }}/" + id,
                    method: "GET",
                    success: function (res) {
                        if (res.status) {
                            $(`tr[data-id="${id}"]`).remove();
                            $('.subtotal').text(res.total.toLocaleString('vi-VN') + ' VNĐ');
                            $('.grand-total').text(res.grandTotal.toLocaleString('vi-VN') + ' VNĐ');
                            $('#cart-count').text(res.cartCount || '0');
                        }
                    }
                });
            }
        });

        $('#clear-cart-btn').on('click', function () {
            if (confirm("Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?")) {
                $.ajax({
                    url: "{{ route('cart.clear') }}",
                    method: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function (res) {
                        if (res.status) {
                            $('#cart tbody').empty();
                            $('.subtotal').text('0 VNĐ');
                            $('.grand-total').text('0 VNĐ');
                            $('#cart-count').text('0');
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
