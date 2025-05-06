@extends('admin.layout.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách Đơn hàng</h1>
            </div>
            <div class="col-sm-6 text-right">
                {{-- Tìm kiếm và lọc trạng thái --}}
                <form action="{{ route('admin.orders.index') }}" method="GET">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" name="search" class="form-control float-right" placeholder="Tìm kiếm" value="{{ request('search') }}">
                        <select name="status" class="form-control float-right ml-2" style="width: 150px;">
                            <option value="">Tất cả trạng thái</option>
                            <option value="{{ \App\Models\Order::STATUS_PENDING }}" {{ request('status') == \App\Models\Order::STATUS_PENDING ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="{{ \App\Models\Order::STATUS_CONFIRMED }}" {{ request('status') == \App\Models\Order::STATUS_CONFIRMED ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="{{ \App\Models\Order::STATUS_SHIPPING }}" {{ request('status') == \App\Models\Order::STATUS_SHIPPING ? 'selected' : '' }}>Đang vận chuyển</option>
                            <option value="{{ \App\Models\Order::STATUS_COMPLETED }}" {{ request('status') == \App\Models\Order::STATUS_COMPLETED ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="{{ \App\Models\Order::STATUS_CANCELLED }}" {{ request('status') == \App\Models\Order::STATUS_CANCELLED ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách đơn hàng</h3>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>  <!-- Thêm cột "Địa chỉ" -->
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Ngày mua</th>
                            <th>Sản phẩm</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}">OR{{ $order->id }}</a></td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->address }}</td>  <!-- Hiển thị địa chỉ -->
                                <td>
                                    @php
                                        $statusLabels = [
                                            'chua_xac_nhan' => ['text' => 'Chưa xác nhận', 'color' => '#f39c12'],   // vàng
                                            'da_xac_nhan' => ['text' => 'Đã xác nhận', 'color' => '#007bff'],         // xanh dương
                                            'dang_van_chuyen' => ['text' => 'Đang vận chuyển', 'color' => '#17a2b8'], // xanh lá cây
                                            'hoan_thanh' => ['text' => 'Hoàn thành', 'color' => '#28a745'],           // xanh lá cây đậm
                                            'huy' => ['text' => 'Đã hủy', 'color' => '#dc3545'],                      // đỏ
                                        ];
                                        $status = $statusLabels[$order->status] ?? ['text' => $order->status, 'color' => '#6c757d'];  // màu xám nếu không xác định được
                                    @endphp
                                    <span class="badge" style="background-color: {{ $status['color'] }}; color: white; padding: 5px 10px; border-radius: 12px; font-weight: bold;">
                                        {{ $status['text'] }}
                                    </span>
                                </td>
                                <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                <td>{{ \Carbon\Carbon::parse($order->ordered_at)->format('d/m/Y H:i') }}</td>

                                <td>
                                    @if($order->orderItems->count() > 0)
                                        <ul>
                                            @foreach($order->orderItems as $item)
                                                <li>
                                                    {{ $item->name }} x {{ $item->quantity }} ({{ number_format($item->price, 0, ',', '.') }} VNĐ)
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>Không có sản phẩm trong đơn hàng.</p>
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @if($order->status == 'chua_xac_nhan')
                                            <button name="confirm" class="btn btn-sm btn-success" title="Xác nhận">
                                                <i class="fas fa-check"></i> Xác nhận
                                            </button>
                                            <button name="cancel" class="btn btn-sm btn-danger" title="Hủy">
                                                <i class="fas fa-times"></i> Hủy
                                            </button>
                                        @elseif($order->status == 'da_xac_nhan')
                                            <button name="shipping" class="btn btn-sm btn-info" title="Giao hàng">
                                                <i class="fas fa-truck"></i> Giao hàng
                                            </button>
                                        @elseif($order->status == 'dang_van_chuyen')
                                            <button name="complete" class="btn btn-sm btn-primary" title="Hoàn thành">
                                                <i class="fas fa-check-circle"></i> Hoàn thành
                                            </button>
                                        @endif
                                    </form>
                                  
                                    {{-- Icon "Sửa" --}}
                                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                  
                                    {{-- Icon "Xóa" --}}
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
