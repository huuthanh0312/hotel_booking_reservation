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
                    <li class="breadcrumb-item active" aria-current="page">Data Testimonials</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('testimonial.add')}}" class="btn btn-outline-primary px-5 radius-30">Add Testimonial</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Testimonials</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered text-center">
                    <thead >
                        <tr>
                            <th>SL</th>
                            <th>IMAGE</th>
                            <th>NAME</th>
                            <th>CITY</th>
                            
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td><img class="rounded-circle p-1 bg-primary" src="{{ (!empty($item->image)) ? url($item->image) 
                                                             : url('upload/no_image.jpg')}}" width="50">
                             </td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->city}}</td>
                           
                            <td>
                                <a href="{{ route('testimonial.edit', $item->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                <a href="{{ route('testimonial.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
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