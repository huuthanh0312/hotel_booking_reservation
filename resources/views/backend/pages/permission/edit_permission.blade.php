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
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('permission.all')}}" class="btn btn-outline-primary px-5 radius-30">All Permission</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center">Update Permission</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('permission.update')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$permission->id}}">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Permission Name</h6>
                        </div>
                        <div class="form-group col-sm-9 text-secondary">
                            <input type="text" name="name" value="{{$permission->name}}" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Permission Group</h6>
                        </div>
                        <div class="form-group col-sm-9 text-secondary">
                            <select name="group_name" class="form-select" id="" required>
                                <option value="">Choese Group Name</option>
                                <option value="Team" {{$permission->group_name == 'Team' ? 'selected' : ''}}>Team</option>
                                <option value="Book Area" {{$permission->group_name == 'Book Area' ? 'selected' : ''}}>Book Area</option>
                                <option value="Manage Room" {{$permission->group_name == 'Manage Room' ? 'selected' : ''}}>Manage Room</option>
                                <option value="Booking" {{$permission->group_name == 'Booking' ? 'selected' : ''}}>Booking</option>
                                <option value="RoomList" {{$permission->group_name == 'RoomList' ? 'selected' : ''}}>RoomList</option>
                                <option value="Setting" {{$permission->group_name == 'Setting' ? 'selected' : ''}}>Setting</option>
                                <option value="Testimonial" {{$permission->group_name == 'Testimonial' ? 'selected' : ''}}>Testmonial</option>
                                <option value="Blog" {{$permission->group_name == 'Blog' ? 'selected' : ''}}>Blog</option>
                                <option value="Manage Comment" {{$permission->group_name == 'Manage Comment' ? 'selected' : ''}}>Manage Comment</option>
                                <option value="Hotel Gallery" {{$permission->group_name == 'Hotel Gallery' ? 'selected' : ''}}>Hotel Gallery</option>
                                <option value="Contact Message" {{$permission->group_name == 'Contact Message' ? 'selected' : ''}}>Contact Message</option>
                                <option value="Role And Permission" {{$permission->group_name == 'Role And Permission' ? 'selected' : ''}}>Role And Permission</option>

                            </select>
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




@endsection