@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">     
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Admin User Setup</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                
                <a href="{{ route('admin.user.add')}}" class="btn btn-outline-primary px-5 radius-30">Add Admin User</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    
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
                            <th>EMAIL</th>
                            <th>PHONE</th>
                            <th>ROLE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allAdmin as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td><img class="rounded-circle p-1 bg-primary" src="{{ (!empty($item->photo)) ? url('upload/admin_images/'.$item->photo) 
                                : url('upload/no_image.jpg')}}" width="50"></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td> 
                            @foreach ($item->roles as $role)
                                <span class="badge bg-danger">{{$role->name}}</span>
                            @endforeach
                           
                            </td>
                            <td>
                                {{-- @if (Auth::user()->can('testimonial.delete'))

                                @endif
                                @if (Auth::user()->can('testimonial.delete'))
                                
                                @endif --}}
                                <a href="{{ route('admin.user.edit', $item->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                <a href="{{ route('admin.user.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
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