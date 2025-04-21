@extends('admin.layout.app')
@section('content')
    
<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="subcategory.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="post" name="subCategoryForm" id="subCategoryForm">
            @csrf
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Chọn Loại Sản Phẩm </option>
                                @if ($categories->isNotEmpty())
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">	
                        </div>
                    </div>	
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" placeholder="status">
                                <option value="1">Block</option>
                                <option value="0">Unlock</option>
                            </select>
                        </div>
                    </div>		
                    							
                </div>
            </div>							
        </div>
        
        <div class="pb-5 pt-3">
            <button class="btn btn-primary" type="submit">Create</button>
            <a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>
</section>
<!-- /.content -->

@endsection

@section('customjs')
<script>

$("#subCategoryForm").submit(function(event){
            event.preventDefault();
            var element = $("#subCategoryForm");    
            $("button[type=submit]").prop('disabled',true);
            $.ajax({
                url:'{{ route("subcategories.store")}}',
                type:'post',
                data: element.serializeArray(),
                dataType:'json',
                success:function(response){
                    $("button[type=submit]").prop('disabled',false);
                if(response['status'] == true )
                {
                //  window.location.href='{{ route('categories.index')}}';

                //     $("#name")
                //         .removeClass('is-invalid')
                //         .siblings('p')
                //         .removeClass('invalid-feedback').html("");
                //     $("#slug")
                //         .removeClass('is-invalid')
                //         .siblings('p')
                //         .removeClass('invalid-feedback').html("");
                } else{
                    var errors = response['errors'];
                    if(errors['name']){
                        $("#name")
                        .addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['name']);
                    } else{
                        $("#name")
                        .removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }


                    if(errors['slug']){
                        $("#slug")
                        .addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['slug']);
                    } else{
                        $("#slug")
                        .removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }
                    if(errors['category_id']){
                        $("#category_id")
                        .addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['category_id']);
                    } else{
                        $("#category_id")
                        .removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }

                }

                   
                },error: function(jqXHR , exception){
                    console.log("Something went wrong ");
                    
                }
                
            })
        });

$("#name").change(function(){
            element =  $(this);
            $("button[type=submit]").prop('disabled',true);
        $.ajax({
                url:'{{ route("getSlug")}}',
                type:'get',
                data: {title: element.val()},
                dataType:'json',
                success:function(response){
                    $("button[type=submit]").prop('disabled',false);
                    if(response["status"] == true){
                        $("#slug").val(response["slug"]);
                    }
                }
            });
    });
</script>
        
@endsection
