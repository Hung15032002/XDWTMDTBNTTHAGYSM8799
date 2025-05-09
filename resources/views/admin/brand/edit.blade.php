@extends('admin.layout.app')
@section('content')

<div class="container-fluid">
    <form action="{{ route('brands.update', $brand->id) }}" method="POST" id="brandForm">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Nhãn Hàng</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Tên nhãn hàng" value="{{ $brand->name }}" required>
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $brand->slug }}" required>
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select name="status" id="status" class="form-control">
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

@section('customjs')
<script>
    // Form submit using AJAX
    $("#brandForm").submit(function(event){
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);

    $.ajax({
        url: '{{ route("brands.update", $brand->id) }}',
        type: 'POST',
        data: element.serialize(),
        dataType: 'json',
        headers: {
            'X-HTTP-Method-Override': 'PUT'
        },
        success: function(response){
            $("button[type=submit]").prop('disabled', false);
            if(response.status === true) {
                // Redirect to the list page on success
                window.location.href = '{{ route('brands.index') }}'; // Điều hướng lại
            } else {
                // Handle errors (showing error messages)
                handleErrors(response.errors);
            }
        },
        error: function(){
            $("button[type=submit]").prop('disabled', false);
            console.log("Something went wrong");
        }
    });
});

    // Generate Slug automatically from Name field
    $("#name").change(function(){
        var element = $(this);
        $.ajax({
            url: '{{ route("getSlug") }}',
            type: 'GET',
            data: {title: element.val()},
            dataType: 'json',
            success: function(response){
                if(response.status === true) {
                    $("#slug").val(response.slug);
                }
            }
        });
    });

    // Function to handle validation errors
    function handleErrors(errors) {
        if (errors['name']) {
            $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
        } else {
            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
        
        if (errors['slug']) {
            $("#slug").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
        } else {
            $("#slug").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
        }
    }

</script>
@endsection
