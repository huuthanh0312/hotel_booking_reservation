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
                <form action="{{ route('gallery.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                
                    <div class="col-md-6">
                        <label for="photo_name" class="form-label">Gallery Image</label>
                        <input type="file" name="photo_name[]" class="form-control" id="photo_name"
                            placeholder="image" accept="image/jpeg, image/png, image/gif, image/jpg" multiple>
                        <br>
                       
                        <div class="row" id="preview_img"></div>
                    </div>
                 
                    <div class="row">
                        
                        <div class="col-sm-12 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!--------===Show MultiImage ========------->
<script>
    $(document).ready(function(){
     $('#photo_name').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(80); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
</script>
<!--------===Show Image ========------->



@endsection