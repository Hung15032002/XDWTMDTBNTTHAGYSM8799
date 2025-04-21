@extends('admin.layout.app')
@section('content')

<div class="container-fluid">
    <form action="{{ route('brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Nhãn Hàng</label>
                    <input type="text" name="name" class="form-control" value="{{ $brand->name }}">
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ $brand->slug }}">
                </div>
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Kích Hoạt</option>
                        <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Không Kích Hoạt</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập Nhật Nhãn Hàng</button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-dark">Hủy</a>
            </div>
        </div>
    </form>
</div>

@endsection

