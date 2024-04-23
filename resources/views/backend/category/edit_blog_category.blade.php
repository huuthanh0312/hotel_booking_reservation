@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Blog Category</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('blog.category.all')}}" class="btn btn-outline-primary px-5 radius-30" >All Blog Category</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center">Update Blog Category</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('blog.category.update')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $blog_category->id }}" />
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Category Name</h6>
                        </div>
                        <div class="form-group col-sm-9 text-secondary">
                            <input type="text" name="category_name" class="form-control" value="{{ $blog_category->category_name }}"/>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- validate form  --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                category_name: {
                    required : true,
                },
                category_slug: {
                    required : true,
                },                               
            },
            messages :{
                category_name: {
                    required : 'Please Enter Team Name',
                }, 
                category_slug: {
                    required : 'Please Enter Position',
                }, 
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>




@endsection