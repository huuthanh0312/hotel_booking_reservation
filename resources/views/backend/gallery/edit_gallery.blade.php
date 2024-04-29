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
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('gallery.all')}}" class="btn btn-outline-primary px-5 radius-30">All Gallery</a>
                
            </div>
        </div>
    </div>
    
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('gallery.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{$gallery->id}}">
                        <div class="col-md-6">
                            <label for="photo_name" class="form-label">Gallery Image</label>
                            <input type="file" name="photo_name" class="form-control" id="photo_name">
                             
                        </div>
                        <div class="col-md-6 pt-2">
                            <img id="showImage" src="{{ asset($gallery->photo_name)}}" 
                            class="rounded p-1 bg-primary" width="100">
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-12 p-2 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    // ajax call image upload change img profile
    $(document).ready(function(){
        $('#photo_name').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection