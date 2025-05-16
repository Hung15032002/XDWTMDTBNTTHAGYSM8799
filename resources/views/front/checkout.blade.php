@extends('front.layout.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Thông tin thanh toán</h3>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">
            <div class="col-md-8">
                {{-- Thông tin người mua --}}
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" required>
                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Hình thức thanh toán --}}
                <div class="form-group">
                    <label for="payment_method">Hình thức thanh toán</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Thanh toán khi nhận hàng</option>
                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Chuyển khoản</option>
                    </select>
                    @error('payment_method') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div id="deposit-info" class="alert alert-info mt-3 d-none">
                    <strong>Lưu ý:</strong> Với hình thức <em>Thanh toán khi nhận hàng</em>, bạn cần đặt cọc trước <strong>5%</strong> tổng giá trị đơn hàng.
                </div>

                <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
            </div>

            <div class="col-md-4">
                <h5>Đơn hàng của bạn</h5>
                <ul class="list-group mb-3">
                    @php $total = 0; @endphp
                    @forelse(session('cart', []) as $item)
                        @php $subtotal = $item['quantity'] * $item['price']; $total += $subtotal; @endphp
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $item['name'] }} x {{ $item['quantity'] }}
                            <span>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span>
                        </li>
                    @empty
                        <li class="list-group-item text-center">Giỏ hàng trống</li>
                    @endforelse

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Tổng cộng</span>
                        <strong id="total-price">{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                    </li>

                    <li class="list-group-item d-flex justify-content-between d-none" id="deposit-amount-row">
                        <span>Tiền cọc (5%)</span>
                        <strong id="deposit-amount"></strong>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>

{{-- JS hiển thị tiền cọc --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethod = document.getElementById('payment_method');
        const depositRow = document.getElementById('deposit-amount-row');
        const depositInfo = document.getElementById('deposit-info');
        const depositDisplay = document.getElementById('deposit-amount');
        const total = {{ $total ?? 0 }};
        const depositAmount = Math.round(total * 0.05);
        const formattedDeposit = depositAmount.toLocaleString('vi-VN') + ' VNĐ';

        function updateDepositDisplay() {
            if (paymentMethod.value === 'cod') {
                depositRow.classList.remove('d-none');
                depositInfo.classList.remove('d-none');
                depositDisplay.textContent = formattedDeposit;
            } else {
                depositRow.classList.add('d-none');
                depositInfo.classList.add('d-none');
            }
        }

        paymentMethod.addEventListener('change', updateDepositDisplay);
        updateDepositDisplay();
    });
</script>

{{-- Modal hiển thị sau khi đặt hàng thành công --}}
@if(session('success_modal'))
<!-- Modal -->
<div class="modal fade" id="orderSuccessModal" tabindex="-1" role="dialog" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="orderSuccessModalLabel">🎉 Đặt hàng thành công</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ session('success_modal') }}

        <hr>
        <h6>Mã QR chuyển khoản:</h6>
        @php
            $amount = number_format(session('deposit_amount', 50000), 0, ',', '.'); // fallback 50k nếu chưa set
            $qrContent = "Người nhận: Nguyễn Văn A\n"
                       . "Số tài khoản: 123456789\n"
                       . "Ngân hàng: Vietcombank\n"
                       . "Số tiền: {$amount} VND\n"
                       . "Nội dung: THANHTOAN_" . \Illuminate\Support\Str::slug(session('success_modal'));
        @endphp
        {!! QrCode::encoding('UTF-8')->size(200)->generate($qrContent) !!}
      </div>
      <div class="modal-footer">
        <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
        modal.show();
    });
</script>
@endif
@endsection
