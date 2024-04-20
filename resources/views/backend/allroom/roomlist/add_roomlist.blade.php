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
                    <li class="breadcrumb-item active" aria-current="page">Data Room List</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('view.room.list')}}" class="btn btn-outline-primary px-5 radius-30">All Room List</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase text-center">Add Room Guest</h6>
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('store.room.list')}}" method="post"  class="row g3">
                    @csrf
                    <div class="col-md-4">
                        <label for="roomtype_id" class="form-label">Room Type</label>
                        <select name="room_id" id="room_id" class="form-select">
                                <option selected="">Select Room Type</option>
                            @foreach ($roomtype as $item)
                                <option value="{{$item->room->id}}" {{collect(old('roomtype_id'))->contains($item->id) ? 'selected' : ''}} >
                                    {{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="check_in" class="form-label">Check In</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" />
                        
                    </div>
                    <div class="col-md-4">
                        <label for="check_out" class="form-label">Check Out</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" />                
                    </div>
                    
                    <div class="col-md-4">
                        <label for="number_of_rooms" class="form-label">Room</label>
                        <input type="number" name="number_of_rooms" id="number_of_rooms" class="form-control" /> 

                        <input type="hidden" name="available_room" id="available_room"> 
                        <div class="mt-2">
                            <label for="">Availability <span class="text-success availability"></span></label>
                        </div>              
                    </div>

                    <div class="col-md-4">
                        <label for="number_of_persion" class="form-label">Guest</label>
                        <input type="number" name="number_of_persion" id="number_of_persion" class="form-control" />                
                    </div>

                    <h3 class="mt-3 mb-5 text-center">Customer Information</h3>
                    <div class="col-md-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{old('name')}}" />                
                    </div>             
                    <div class="col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="emial" name="email" id="email" class="form-control"
                            value="{{old('email')}}" />                
                    </div>              
                    <div class="col-md-4">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{old('phone')}}" />                
                    </div>
                  
                    <div class="col-md-4">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" name="country" id="country" class="form-control"
                            value="{{old('country')}}" />                
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>
                        <input type="text" name="state" id="state" class="form-control"
                            value="{{old('state')}}" />                
                    </div>
                    <div class="col-md-4">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control"
                            value="{{old('zip_code')}}" />                
                    </div>                   
                    <div class="col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" rows="3" class="form-control">
                             {{old('address')}}</textarea>                               
                    </div>
                    
                    <div class="col-md-12 pt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Guest Booking</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function(){

        $("#roon_id").on("change", function(){
            $("#check_in").val('');
            $("#check_out").val('');
            $("#availability").text('0');
            $("#available_room").val(0);
            
        });
        $("#check_out").on("change", function(){
            //get available_room
            getAvaility();
        })
        

        

    });

    function getAvaility(){
        var check_in = $('#check_in').val();
        var check_out = $('#check_out').val();
        var room_id = $('#room_id').val();

        // validate check in and out room
        var startDate = new Date(check_in);
        var endDate = new Date(check_out);
        if(startDate > endDate){
            alert('Invalid Date');
            $("#check_out").val('');
            return false;
        }
        if(check_in != '' && check_out != '' && room_id !=''){
            $.ajax({
            url: "{{route('check.room.availability')}}",
            data: {room_id:room_id, check_in:check_in, check_out:check_out},
            success: function(data){
                $(".availability").text(data['available_room']);
                $("#available_room").val(data['available_room']);

                    
                }
            }); //call ajax method check room
        } else{
            alert('Field must be not empty');
        }
        
    }
</script>
@endsection