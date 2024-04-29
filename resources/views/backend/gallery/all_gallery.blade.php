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
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('gallery.add')}}" class="btn btn-outline-primary px-5 radius-30">Add Gallery</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Photo Gallery</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('delete.gallary.multiple')}}" method="post">
                    @csrf
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead >
                            <tr>
                                <th>SELECT</th>
                                <th>SL</th>
                                <th>IMAGE</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($galleries as $key => $item)
                            
                            <tr>
                                <td>
                                    <input type="checkbox" name="selectItem[]" id="" value="{{ $item->id}}">
                                </td>
                                <td>{{ $key +1 }}</td>
                                <td><img class="p-1" src="{{url($item->photo_name)}}" width="70" height="70">
                                </td>
                            
                                <td>
                                    <a href="{{ route('gallery.edit', $item->id)}}"  class="btn btn-outline-warning px-5 radius-30">Edit</a>
                                    <a href="{{ route('gallery.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    <button type="submit" class="btn btn-outline-danger">Deleted Select</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection