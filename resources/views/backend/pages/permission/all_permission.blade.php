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
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('permission.import')}}" class="btn btn-outline-success px-5 radius-30">Import Permission</a>
                <a href="{{ route('export')}}" class="btn btn-outline-warning px-5 radius-30">Export Permission</a>
                <a href="{{ route('permission.add')}}" class="btn btn-outline-primary px-5 radius-30">Add Permission</a>
                
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
                            <th>PERMINSSION NAME</th>
                            <th>GROUP NAME</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->group_name}}</td>
                            <td>
                                {{-- @if (Auth::user()->can('testimonial.delete'))

                                @endif
                                @if (Auth::user()->can('testimonial.delete'))
                                
                                @endif --}}
                                <a href="{{ route('permission.edit', $item->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                <a href="{{ route('permission.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
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