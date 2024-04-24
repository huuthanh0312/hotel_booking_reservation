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
                    <li class="breadcrumb-item active" aria-current="page">Data Post</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('blog.post.all')}}" class="btn btn-outline-primary px-5 radius-30">All Posts</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center">Update Post</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('blog.post.update')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$post->id}}">
                    <div class="row p-2">
                        <div class="col-md-6 p-2">
                            <label for="blogcat_id" class="form-label">Category</label>
                            <select name="blogcat_id" id="blogcat_id" class="form-select">
                                <option selected="">Select Category</option>
                                @foreach ($blog_category as $category)
                                    <option value="{{$category->id}}" {{$post->blogcat_id == $category->id ? ' selected="selected"' : ''}} >{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 p-2">
                            <label for="post_title" class="form-label">Post Title</label>
                            <input type="text" name="post_title" id="post_title" class="form-control" value="{{$post->post_title}}"/>                
                        </div>
                        <div class="col-md-12 p-2">
                            <label for="short_descp" class="form-label">Short Description</label>                
                            <textarea name="short_descp" id="" rows="4" class="form-control">{{$post->short_descp}}</textarea>               
                        </div>
                        <div class="col-md-12 p-2">
                            <label for="post_title" class="form-label"> Description</label>
                            <textarea name="long_descp" id="content_tindy" class="form-control">{{$post->long_descp}}</textarea>           
                        </div>
                   
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Photo</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="file" name="post_image" class="form-control" id="image" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0"></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <img id="showImage" src="{{ !(empty($post->post_image)) ? url($post->post_image) :
                                url('/upload/no_image.jpg')}}" 
                                class="rounded-circle p-1 bg-primary" width="80">
                        </div>
                    </div>
                    <div class="row">                     
                        <div class="col-sm-12 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- load image call ajax --}}
<script type="text/javascript">
    // ajax call image upload change img profile
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>


@endsection