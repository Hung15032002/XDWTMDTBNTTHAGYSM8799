@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <form action="{{ route('products.store') }}" method="post" id="productForm">
        @csrf
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Tên sản phẩm</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Tên sản phẩm">	
                        <p class="text-danger" id="error-name"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">	
                        <p class="text-danger" id="error-slug"></p>
                    </div>			

                    <div class="col-md-6 mb-3">
                        <label for="price">Giá</label>
                        <input type="number" name="price" class="form-control" placeholder="Giá sản phẩm">
                        <p class="text-danger" id="error-price"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="code">Mã sản phẩm</label>
                        <input type="text" name="code" class="form-control" placeholder="Mã sản phẩm">
                        <p class="text-danger" id="error-code"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="qty">Số lượng</label>
                        <input type="number" name="qty" class="form-control" placeholder="Số lượng">
                        <p class="text-danger" id="error-qty"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status">Trạng thái</label>
                        <input type="hidden" name="status" value="0">
                        <select name="status" class="form-control">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="brand_id">Thương hiệu</label>
                        <select name="brand_id" class="form-control">
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger" id="error-brand_id"></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="subcategory_id">Danh mục phụ</label>
                        <select name="subcategory_id" class="form-control">
                            <option value="">-- Chọn danh mục phụ --</option>
                            @foreach($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-danger" id="error-subcategory_id"></p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description">Mô tả</label>
                        <textarea name="description" class="form-control" placeholder="Mô tả sản phẩm"></textarea>
                    </div>

                    <input type="hidden" id="image_id" name="image_id" value="">

                    <div class="col-md-12 mb-3">
                        <label for="image">Hình ảnh</label>
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">    
                                <br>Thả ảnh vào đây hoặc click để tải lên.<br><br>                                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>							
        </div>

        <div class="pt-3 pb-5">
            <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Hủy</a>
        </div>
    </form>
</div>
@endsection

@section('customjs')
<script>
    // Tự động tạo slug từ name
    $("#name").change(function(){
        var element = $(this);
        $.ajax({
            url:'{{ route("getSlug")}}',
            type:'get',
            data: { title: element.val() },
            dataType:'json',
            success:function(response){
                if(response.status){
                    $("#slug").val(response.slug);
                }
            }
        });
    });

    // Dropzone cấu hình
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({ 
        url: "{{ route('temp-images.create') }}",
        maxFiles: 10,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response){
            let imageIds = $("#image_id").val();
            imageIds = imageIds ? imageIds.split(',') : [];
            imageIds.push(response.image_id);
            $("#image_id").val(imageIds.join(','));
        },
        removedfile: function(file) {
            if (file.previewElement != null) {
                file.previewElement.parentNode.removeChild(file.previewElement);
            }
        }
    });

    // Gửi form bằng AJAX
    $("#productForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);

        // Xóa lỗi cũ
        $(".text-danger").text('');

        $.ajax({
            url: '{{ route("products.store") }}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response.status) {
                    window.location.href = '{{ route("products.index") }}';
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    }
                }
            },
            error: function() {
                console.log("Đã có lỗi xảy ra.");
                $("button[type=submit]").prop('disabled', false);
            }
        });
    });
</script>
@endsection
