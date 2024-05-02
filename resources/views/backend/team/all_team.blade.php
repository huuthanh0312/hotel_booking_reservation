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
                    <li class="breadcrumb-item active" aria-current="page">Data Team</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.team')}}" class="btn btn-outline-primary px-5 radius-30">Add Team</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Teams</h6>
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
                            <th>POSITION</th>
                            <th>FACEBOOK</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td><img class="rounded-circle p-1 bg-primary" src="{{ (!empty($item->image)) ? url('upload/team/'.$item->image) 
                                                             : url('upload/no_image.jpg')}}" width="50">
                             </td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->position}}</td>
                            <td>{{$item->facebook}}</td>
                            <td>
                                @if (Auth::user()->can('team.edit'))
                                <a href="{{ route('team.edit', $item->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                @endif
                                @if (Auth::user()->can('team.delete'))
                                <a href="{{ route('team.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
                                @endif
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