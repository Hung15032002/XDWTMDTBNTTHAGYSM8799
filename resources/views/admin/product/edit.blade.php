@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('products.update', $product->id) }}" method="post" id="productForm">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Tên sản phẩm -->
                    <div class="col-md-6 mb-3">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}">
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $product->slug) }}">
                    </div>

                    <!-- Brand -->
                    <div class="col-md-6 mb-3">
                        <label for="brand_id">Thương hiệu</label>
                        <select name="brand_id" class="form-control">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subcategory -->
                    <div class="col-md-6 mb-3">
                        <label for="subcategory_id">Danh mục phụ</label>
                        <select name="subcategory_id" class="form-control">
                            <option value="">-- Chọn danh mục phụ --</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Giá -->
                    <div class="col-md-4 mb-3">
                        <label for="price">Giá</label>
                        <input type="number" class="form-control" name="price" value="{{ old('price', $product->price) }}">
                    </div>

                    <!-- Mã sản phẩm -->
                    <div class="col-md-4 mb-3">
                        <label for="code">Mã sản phẩm</label>
                        <input type="text" class="form-control" name="code" value="{{ old('code', $product->code) }}">
                    </div>

                    <!-- Số lượng -->
                    <div class="col-md-4 mb-3">
                        <label for="qty">Số lượng</label>
                        <input type="number" class="form-control" name="qty" value="{{ old('qty', $product->qty) }}">
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-6 mb-3">
                        <label for="status">Trạng thái</label>
                        <input type="hidden" name="status" value="0">
                        <select name="status" class="form-control">
                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-md-12 mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Ảnh sản phẩm -->
                    <div class="col-md-12 mb-3">
                        <label for="image">Hình ảnh</label>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                Thả ảnh vào đây hoặc click để tải lên
                            </div>
                        </div>

                        @if ($product->image)
                            <div class="mt-2">
                                <p>Ảnh hiện tại:</p>
                                <img src="{{ asset('uploads/product/thumb/' . $product->image) }}" width="100">
                            </div>
                        @endif
                    </div>

                    <!-- Hidden image_id -->
                    <input type="hidden" name="image_id" id="image_id" value="">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="pt-3 pb-5">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Hủy</a>
        </div>
    </form>
</div>
@endsection

@section('customjs')
<script>
    // Tự động tạo slug
    $("#name").change(function () {
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: { title: $(this).val() },
            success: function (response) {
                if (response.status) {
                    $("#slug").val(response.slug);
                }
            }
        });
    });

    // Dropzone config
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        url: "{{ route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: 'image/*',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, response) {
            let ids = $("#image_id").val();
            ids = ids ? ids.split(',') : [];
            ids.push(response.image_id);
            $("#image_id").val(ids.join(','));
        },
        removedfile: function (file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }
    });

    // AJAX submit
    $("#productForm").submit(function (event) {
        event.preventDefault();
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("products.update", $product->id) }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $("button[type=submit]").prop('disabled', false);
                if (response.status) {
                    window.location.href = '{{ route("products.index") }}';
                } else {
                    // Hiển thị lỗi (nếu cần)
                }
            },
            error: function () {
                console.log('Lỗi khi gửi form.');
                $("button[type=submit]").prop('disabled', false);
            }
        });
    });
</script>
@endsection
