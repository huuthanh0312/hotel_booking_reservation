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
                    <li class="breadcrumb-item active" aria-current="page">Admin User</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('admin.user.all')}}" class="btn btn-outline-primary px-5 radius-30">All Admin User</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center"> Add Admin User</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.user.store')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 p-2">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Admin User Name</label>
                            <input type="text" name="name" id="name" class="form-control" />
                            
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Admin User Email</label>
                            <input type="email" name="email" id="email" class="form-control" />
                            
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Admin User Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" />
                            
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label">Admin User Address</label>
                            <input type="text" name="address" id="address" class="form-control" />
                            
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Admin User Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                            
                        </div>
                        <div class="col-md-6">
                            <label for="check_in" class="form-label">Admin User Role</label>
                            <select name="roles" class="form-select" id="" required>
                                <option value="">Choese Role Name</option>
                                @foreach ($role as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                                
                            </select>
                            
                        </div>
                    
                        {{-- <div class="col-sm-12 text-secondary">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" id="image" />
                        </div> --}}
                    </div>
                    {{-- <div class="row mb-3 p-2">
                        <div class="col-sm-3">
                            <h6 class="mb-0"></h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <img id="showImage" src="{{ asset('/upload/no_image.jpg')}}" 
                                class="rounded-circle p-1 bg-primary" width="80">
                        </div>
                    </div> --}}
                    <div class="row p-2">                     
                        <div class="col-sm-12 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
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