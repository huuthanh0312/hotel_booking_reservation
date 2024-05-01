
@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    .from-check-label{
        text-transform: capitalize;
    }
</style>
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Role In Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('role.permission.all')}}" class="btn btn-outline-primary px-5 radius-30">All Role Perission</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center">Role In Permission</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.roles.update', $role->id)}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row p-2">
                        <div class="col-md-6 p-2">
                            
                            <h3>Role Name : {{$role->name}}</h3>
                        </div>
                        <div class="col-md-12 p-2">
                         
                            <input type="checkbox" class="form-check-label" id="CheckDefaultMain">
                            <label for="CheckDefaultMain" class="form-label">Permission All</label>
                        
                        </div>
                        <hr>
                        @foreach ($permission_groups as $permission)
                        <div class="row">
                            @php
                            $permission_group_name = App\Models\User::getPermissionGroupName($permission->group_name);
                            @endphp
                            <div class="col-md-4 p-2">
                                <input type="checkbox" class="form-check-label" id="flexCheckDefault" 
                                    {{ App\Models\User::roleHasPermissions($role, $permission_group_name) ? 'checked' : '' }}>
                                <label for="flexCheckDefault" class="form-label">{{$permission->group_name}}</label>
                            </div>
                            
                            <div class="col-md-6 p-2" >
                                @foreach ($permission_group_name as $item)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-label" name="permission[]" id="flexCheckDefault{{$item->id}}" 
                                        value="{{ $item->id}}"  {{$role->hasPermissionTo($item->name) ? 'checked' : ''}}>
                                        <label for="flexCheckDefault{{$item->id}}" class="form-label">{{ $item->name}}</label>
                                    </div>
                                    
                                @endforeach
                            </div>
                            <hr>
                        </div>
                        @endforeach
                        
                        <div class="col-sm-12 text-secondary">
                            <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                        </div>
                    </div>
                  
    
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $('#CheckDefaultMain').click(function(){
        if($(this).is(":checked")){
            $('input[type=checkbox]').prop('checked', true);
           
        }else{
            $('input[type=checkbox]').prop('checked', false);
        }
    });
</script>


@endsection