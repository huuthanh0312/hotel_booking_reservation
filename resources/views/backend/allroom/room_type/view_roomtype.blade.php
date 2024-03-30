@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Room</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Room Type</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('room.type.add')}}" class="btn btn-outline-primary px-5 radius-30">Add Room Type</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Room Type</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                    <thead >
                        <tr>
                            <th>SL</th>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataRoomType as $key => $item)
                        @php
                            $rooms = App\Models\Room::where('roomtype_id', $item->id)->get();
                        @endphp
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td><img src=" {{(!empty($item->room->image)) ? url($item->room->image) : url('upload/no_image.jpg')}}" width="50px" alt=""></td>
                            <td>{{$item->name}}</td>
                            <td>
                                @foreach ($rooms as $room)                                
                                <a href="{{ route('edit.room', $room->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                <a href="{{ route('delete.room', $room->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>



@endsection