@extends('admin.layout.app')
@section('content')

<div class="container-fluid">
    <form action="{{ route('brands.store') }}" method="POST" id="brandForm">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Tên Nhãn Hàng</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Tên nhãn hàng" required>
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required>
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="status">Trạng Thái</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Kích Hoạt</option>
                        <option value="0">Không Kích Hoạt</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Lưu Nhãn Hàng</button>
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
            url: '{{ route("brands.store") }}',
            type: 'POST',
            data: element.serialize(), // Serialize the form data
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if(response.status === true) {
                    // Redirect to the list page on success
                    window.location.href = '{{ route('brands.index') }}';
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
