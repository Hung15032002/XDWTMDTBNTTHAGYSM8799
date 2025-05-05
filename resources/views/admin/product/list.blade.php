@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Danh Sách Sản Phẩm</h3>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request()->get('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Tìm</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Tên</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Mã SP</th>
                            <th>Số lượng</th>
                            <th>Thương hiệu</th>
                            <th>Danh mục phụ</th>
                            <th>Xuất xứ</th>
                            <th>Chất liệu</th>
                            <th>Kích thước</th>
                            <th>Màu sắc</th>
                            <th>Bảo hành</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('uploads/product/thumb/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ number_format($product->price) }} đ</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->qty }}</td>
                            <td>{{ $product->brand->name ?? 'Không có' }}</td>
                            <td>{{ $product->subcategory->name ?? 'Không có' }}</td>
                            <td>{{ $product->origin ?? 'N/A' }}</td>
                            <td>{{ $product->material ?? 'N/A' }}</td>
                            <td>{{ $product->dimensions ?? 'N/A' }}</td>
                            <td>{{ $product->color ?? 'N/A' }}</td>
                            <td>{{ $product->warranty ?? 'N/A' }}</td>
                            <td>
                                @if ($product->status == 1)
                                    <svg class="text-success-500 h-6 w-6 text-success" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </td>
                            <td class="d-flex align-items-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-delete-product"
                                        data-url="{{ route('products.destroy', $product->id) }}"
                                        title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-3">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScript AJAX xóa -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-product');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error("Lỗi khi xóa!");
                        return res.json();
                    })
                    .then(data => {
                        this.closest('tr').remove();
                        alert('Đã xóa thành công!');
                    })
                    .catch(err => {
                        alert('Xóa thất bại!');
                        console.error(err);
                    });
                }
            });
        });
    });
</script>
@endsection
