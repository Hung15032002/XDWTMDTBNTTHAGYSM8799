@extends('admin.layout.app')
@section('content')

<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <form action="" method="post" name="subCategoryForm" id="subCategoryForm">
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Chọn Loại Sản Phẩm </option>
                                    @if ($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-danger" id="error-category_id"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                <p class="text-danger" id="error-name"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                                <p class="text-danger" id="error-slug"></p>
                            </div>
                        </div>	

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Hiển thị</option>
                                    <option value="0">Ẩn</option>
                                </select>
                            </div>
                        </div>		
                    </div>
                </div>							
            </div>
        
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Create</button>
                <a href="{{ route('subcategories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection

@section('customjs')
<script>
    // Gửi form bằng AJAX
    $("#subCategoryForm").submit(function(event){
        event.preventDefault();
        var form = $(this);    
        $("button[type=submit]").prop('disabled', true);

        // Xóa thông báo lỗi cũ
        $("#error-name, #error-slug, #error-category_id").html('');

        $.ajax({
            url: '{{ route("subcategories.store") }}',
            type: 'POST',
            data: form.serializeArray(),
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if(response.status === true) {
                    alert(response.message);
                    window.location.href = response.redirect_url;
                } else {
                    let errors = response.errors;
                    if(errors.name){
                        $("#error-name").html(errors.name);
                    }
                    if(errors.slug){
                        $("#error-slug").html(errors.slug);
                    }
                    if(errors.category_id){
                        $("#error-category_id").html(errors.category_id);
                    }
                }
            },
            error: function() {
                $("button[type=submit]").prop('disabled', false);
                alert('Lỗi khi gửi dữ liệu. Vui lòng thử lại!');
            }
        });
    });

    // Tự tạo slug từ name
    $("#name").change(function(){
        let element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: { title: element.val() },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if(response.status === true){
                    $("#slug").val(response.slug);
                }
            }
        });
    });
</script>
@endsection
