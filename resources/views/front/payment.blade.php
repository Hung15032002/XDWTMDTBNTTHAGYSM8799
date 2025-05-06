@extends('front.layout.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Thông báo thanh toán</h3>

    <div class="alert alert-success">
        <h4>🎉 Thanh toán thành công!</h4>
        <p>{{ $message }}</p>
        <p><strong>Cảm ơn bạn đã đặt hàng!</strong></p>
        <p>Chúng tôi sẽ liên lạc với bạn trong ít phút để hoàn tất giao dịch.</p>
        <a href="{{ route('front.home') }}" class="btn btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection
