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
    <h6 class="mb-0 text-uppercase text-center">Permission Add</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('permission.store')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Permission Name</h6>
                        </div>
                        <div class="form-group col-sm-9 text-secondary">
                            <input type="text" name="name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Permission Group</h6>
                        </div>
                        <div class="form-group col-sm-9 text-secondary">
                            <select name="group_name" class="form-select" id="" required>
                                <option value="">Choese Group Name</option>
                                <option value="Team">Team</option>
                                <option value="Book Area">Book Area</option>
                                <option value="Manage">Manage Room</option>
                                <option value="Booking">Booking</option>
                                <option value="RoomList">RoomList</option>
                                <option value="Setting">Setting</option>
                                <option value="Testimonial">Testimonial</option>
                                <option value="Blog">Blog</option>
                                <option value="Manage Comment">Manage Comment</option>
                                <option value="Hotel Gallery">Hotel Gallery</option>
                                <option value="Contact Message">Contact Message</option>
                                <option value="Role And Permission">Role And Permission</option>

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