@extends('admin.layout.app')

@section('content')
<div class="container mt-5">
    <h2>Danh sách thông tin liên hệ</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('pages.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Facebook Link</th>
                <th>Zalo Link</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->facebook_link }}</td>
                    <td>{{ $page->zalo_link }}</td>
                    <td>{{ $page->address }}</td>
                    <td>
                        @foreach (json_decode($page->phone_numbers) as $phone)
                            <p>{{ $phone }}</p>
                        @endforeach
                    </td>
                    <td>
                        <!-- Chỉnh sửa link, sửa lại route để nhận ID -->
                        <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>

                        <!-- Form Xóa thông tin -->
                        <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
