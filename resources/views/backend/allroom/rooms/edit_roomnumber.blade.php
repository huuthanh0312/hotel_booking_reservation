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
                    <li class="breadcrumb-item active" aria-current="page">Edit Room Number</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <h6 class="mb-0 text-uppercase text-center">Update Room Number</h6>
            <hr />
            <div class="row row-cols-1 row-cols-md-1">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action=" {{route('update.room.no', $editRoomNumber->id)}} "class="row g-3">
                                @csrf
                                
                                <div class="col-md-12">
                                    <label for="room_no" class="form-label">Room No</label>
                                    <input type="text" autofocus class="form-control" id="room_no" name="room_no" value="{{$editRoomNumber->room_no}}">
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="form-label">Status Room</label>
                                    <select name="status" id="status" class="form-select">
                                        <option selected="">Choose...</option>
                                        <option value="active" {{ $editRoomNumber->status == 'active' ? ' selected="selected"' : '' }}>Active</option>
                                        <option value="inactive"  {{ $editRoomNumber->status == 'inactive' ? ' selected="selected"' : '' }}>InActive</option>
                                        
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">                    
                                        <button type="submit" class="btn btn-primary px-4">Save</button>
                                    </div>
                                </div>
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--end row-->
</div>


@endsection