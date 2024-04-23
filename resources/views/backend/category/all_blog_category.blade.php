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
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-outline-primary px-5 radius-30">Add Blog Category</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Blog Categories</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                    <thead >
                        <tr>
                            <th>SL</th>
                            <th>CATEBORY NAME</th>
                            <th>CATEGORY SLUG</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blog_categories as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td>{{$item->category_name}}</td>
                            <td>{{$item->category_slug}}</td>d
                            
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#edit_category" id="{{$item->id}}"  onclick="categoryEdit(this.id)"
                                    class="btn btn-outline-warning px-5 radius-30">Edit</button>
                                <a href="{{ route('blog.category.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Add Category -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Blog Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('blog.category.store')}}" method="post" id="myForm" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="category_name" class="form-label text-dark">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control" />                
                </div>      
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Modal Edit Category -->
<div class="modal fade" id="edit_category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Blog Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('blog.category.update')}}" method="post" id="myForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" />
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="category_name" class="form-label text-dark">Category Name</label>
                        <input type="text" name="category_name" id="cat_name" class="form-control" />                
                    </div>      
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function categoryEdit(id){
        $.ajax({
            type: "get",
            url:  "/blog-category/edit/" + id,
            dataType: "json",
            success: function(data){
                $('#id').val(data.id);
                $('#cat_name').val(data.category_name);
            }
        })
    }
</script>

@endsection