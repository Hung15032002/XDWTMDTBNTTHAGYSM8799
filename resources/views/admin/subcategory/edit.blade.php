@extends('admin.layout.app')

@section('content')
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh Sửa Loại Sản Phẩm</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    @include('admin.message')
    <div class="card card-primary">
        <form method="POST" action="{{ route('subcategories.update', $subcategory->id) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Loại Sản Phẩm</label>
                    <input type="text" name="name" value="{{ old('name', $subcategory->name) }}" class="form-control" placeholder="Tên loại sản phẩm">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Danh Mục Sản Phẩm</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection