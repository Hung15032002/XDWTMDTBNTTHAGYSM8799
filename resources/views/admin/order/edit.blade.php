@extends('admin.layout.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Sửa Đơn hàng</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cập nhật thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Tên khách hàng</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $order->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $order->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $order->phone) }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input type="text" name="address" class="form-control" id="address" value="{{ old('address', $order->address) }}">
                    </div>

                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select name="status" class="form-control" id="status">
                            <option value="chua_xac_nhan" {{ $order->status == 'chua_xac_nhan' ? 'selected' : '' }}>Chưa xác nhận</option>
                            <option value="da_xac_nhan" {{ $order->status == 'da_xac_nhan' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="dang_van_chuyen" {{ $order->status == 'dang_van_chuyen' ? 'selected' : '' }}>Đang vận chuyển</option>
                            <option value="hoan_thanh" {{ $order->status == 'hoan_thanh' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="huy" {{ $order->status == 'huy' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ordered_at">Ngày mua</label>
                        @php
                            use Carbon\Carbon;
                            $orderedDate = Carbon::parse($order->ordered_at)->format('Y-m-d');
                        @endphp
                        <input type="date" name="ordered_at" class="form-control" id="ordered_at" value="{{ old('ordered_at', $orderedDate) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Thoát</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
