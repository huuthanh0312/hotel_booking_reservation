@extends('frontend.main_master')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<!-- Inner Banner -->
<div class="inner-banner inner-bg10">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ url('/')}}">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Room Details </li>
            </ul>
            <h3>{{ $detailsRoom['type']['name'] }}</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Room Details Area End -->
<div class="room-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="room-details-side">
                    <div class="side-bar-form">
                        <h3>Booking Sheet </h3>
                        <form method="post" action="{{route('user.booking.store')}}" id="bk_form">
                            @csrf
                            <input type="hidden" name="room_id" value="{{$detailsRoom->id}}">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Check in</label>
                                        <div class="input-group">
                                            <input name="check_in" id="check_in" autocomplete="off" type="text"  class="form-control dt_picker" 
                                                        value="{{old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : ''}}" required>
                                            
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-calendar'></i>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Check Out</label>
                                        <div class="input-group">
                                            <input name="check_out" id="check_out" autocomplete="off" type="text"  class="form-control dt_picker" 
                                                        value="{{old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : ''}}" required>
                                            <span class="input-group-addon"></span>
                                            
                                        </div>
                                        <i class='bx bxs-calendar'></i>
                                        
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Numbers of Persons</label>
                                        <select class="form-control" name="persion" id ="nmbr_persion">
                                            @for ($i = 1; $i <= 4; $i++)
                                            <option {{old('persion')==$i ? 'selected' : ''}} value="0{{$i}}">0{{$i}}</option>
                                            @endfor    
                                        </select>
                                    </div>
                                </div>
                                {{-- get sum total money --}}
                                <input type="hidden" name="total_adult" id="total_adult" value="{{$detailsRoom->total_adult}}">
                                <input type="hidden" name="room_price" id="room_price" value="{{$detailsRoom->price}}" >
                                <input type="hidden" name="discount_p" id="discount_p" value="{{$detailsRoom->discount}}">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Numbers of Rooms</label>
                                        <select class="form-control number_of_rooms" name="number_of_rooms" id ="select_room">
                                            @for ($i = 1; $i <= 5; $i++)
                                            <option value="0{{$i}}">0{{$i}}</option>
                                            @endfor    
                                        </select>
                                    </div>
                                    {{-- available room input --}}
                                    <input type="hidden" name="available_room" id="available_room">
                                    <p class="available_room"></p>
                                </div>
                          
                                <div class="col-lg-12">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><p>SubTotal</p></td>
                                                <td style="text-align: right"> <span class="t_subtotal">0</span> $</td>
                                            </tr>
                                            <tr>
                                                <td><p>Discount</p></td>
                                                <td style="text-align: right"> <span class="t_discount">0</span> $</td>
                                            </tr>
                                            <tr>
                                                <td><p>Total</p></td>
                                                <td style="text-align: right"> <span class="t_g_total">0</span> $</td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="room-details-article">
                    <div class="room-details-slider owl-carousel owl-theme">
                        @foreach($multiImage as $image)
                        <div class="room-details-item">
                            <img src="{{url($image->multi_img)}}" alt="Images" width="1000px" height="700px">
                        </div>
                        @endforeach
                    </div>
                    <div class="room-details-title">
                        <h2>{{ $detailsRoom['type']['name']}}</h2>
                        <ul>
                            <li>
                                <b> Basic : $ {{$detailsRoom->price}}/Night/Room</b>
                            </li>
                        </ul>
                    </div>

                    <div class="room-details-content">
                        <p>
                            {{$detailsRoom->description}}
                        </p>
                        <div class="side-bar-plan">
                            <h3>Basic Plan Facilities</h3>
                            <ul>
                                @foreach( $facility as $faci)
                                <li><a href="#">{{ $faci->facility_name}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="services-bar-widget">
                                    <h3 class="title">Room Details</h3>
                                    <div class="side-bar-list">
                                        <ul>
                                            <li>
                                                <a href="#"> <b>Capacity : </b> {{$detailsRoom->room_capacity}} Person <i
                                                        class='bx bxs-cloud-download'></i></a>
                                            </li>
                                            <li>
                                                <a href="#"> <b>Size : </b> {{$detailsRoom->size}}m2 <i
                                                        class='bx bxs-cloud-download'></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="services-bar-widget">
                                    <h3 class="title">Room Details</h3>
                                    <div class="side-bar-list">
                                        <ul>
                                            <li>
                                                <a href="#"> <b>View : </b> {{$detailsRoom->view}} <i
                                                        class='bx bxs-cloud-download'></i></a>
                                            </li>
                                            <li>
                                                <a href="#"> <b>Bad Style : </b> {{$detailsRoom->bed_style}} <i
                                                        class='bx bxs-cloud-download'></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="room-details-review">
                        <h2>Clients Review and Retting's</h2>
                        <div class="review-ratting">
                            <h3>Your retting: </h3>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                        </div>
                        <form>
                            
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" cols="30" rows="8" required
                                            data-error="Write your message"
                                            placeholder="Write your review here.... "></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn btn-bg-three">
                                        Submit Review
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room Details Area End -->

<!-- Room Details Other -->
<div class="room-details-other pb-70">
    <div class="container">
        <div class="room-details-text">
            <h2>Others Room</h2>
        </div>

        <div class="row ">
            @foreach($othersRoom as $otherRoom)
            <div class="col-lg-6">
                <div class="room-card-two">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-4 p-0">
                            <div class="room-card-img">
                                <a href="{{route('details.froom', $otherRoom->id)}}">
                                    <img src="{{url($otherRoom->image)}}" alt="Images">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="room-card-content">
                                <h3>
                                    <a href="{{route('details.froom', $otherRoom->id)}}">{{ $otherRoom['type']['name']}}</a>
                                </h3>
                                <span>{{$otherRoom->price}}$ / Per Night </span>
                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                </div>
                                <p>{{$otherRoom->short_desc}}</p>
                                <ul>
                                    <li><i class='bx bx-user'></i> {{$otherRoom->room_capacity}} Person</li>
                                    <li><i class='bx bx-expand'></i> {{$otherRoom->size}}m2 </li>
                                </ul>

                                <ul>
                                    <li><i class='bx bx-show-alt'></i> {{$otherRoom->view}}</li>
                                    <li><i class='bx bxs-hotel'></i> {{$otherRoom->bed_style}}</li>
                                </ul>

                                <a href="{{route('details.froom', $otherRoom->id)}}" class="book-more-btn">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           @endforeach
        </div>
    </div>
</div>
<!-- Room Details Other End -->

<script >
    $(document).ready(function(){
        var check_in = '{{old('check_in')}}';
        var check_out = '{{old('check_out')}}';
        var room_id = '{{$room_id}}';
        
        if(check_in != '' && check_out != '' && check_in < check_out){
            
            getAvaility(check_in, check_out, room_id );
        } 

        $("#check_in").on('change', function(){
            var check_in = $(this).val();
            var check_out = $("#check_out").val();
            
            if(check_in != '' && check_out != '' && check_in < check_out){
                getAvaility(check_in, check_out, room_id );
            } else{
                alert('Sorry You Can Chose Date Disable');
                $("#check_in").val('{{old('check_in')}}');
                $("#check_out").val('{{old('check_out')}}');
                
            }
        }); // get value check in and out

        $("#check_out").on('change', function(){
            var check_out = $(this).val();
            var check_in = $("#check_in").val();
            
            if(check_in != '' && check_out != '' && check_in < check_out){
                getAvaility(check_in, check_out, room_id );
            } else{
                alert('Sorry You Can Chose Date Disable');
                $("#check_in").val('{{old('check_in')}}');
                $("#check_out").val('{{old('check_out')}}');
                
            }
        }); // get value check in and out

        $(".number_of_rooms").on('change', function(){
            var check_out = $("#check_out").val();
            var check_in = $("#check_in").val();
            
            if(check_in != '' && check_out != '' && check_in < check_out){
                getAvaility(check_in, check_out, room_id );
            } else{
                $("#check_in").val('{{old('check_in')}}');
                $("#check_out").val('{{old('check_out')}}');
                alert('Sorry You Can Chose Date Disable');
                
            }
        }); // get value check in and out

        function getAvaility(check_in, check_out, room_id){
            $.ajax({
                url: "{{route('check.room.availability')}}",
                data: {room_id:room_id, check_in:check_in, check_out:check_out},
                success: function(data){
                    $(".available_room").html('Availability : <span class="text-success">'
                        +data['available_room'] + ' Rooms</span>');
                    $("#available_room").val(data['available_room']);

                    price_calculate(data['total_nights']);
                    
                }
            }); //call ajax method check room
        }

        function price_calculate(total_nights){
            var room_price = $("#room_price").val();
            var discount_p = $("#discount_p").val();
            var select_room = $("#select_room").val();
            
            var sub_total = room_price * total_nights * parseInt(select_room);
            var discount_price = (parseInt(discount_p)/100)*sub_total;
            $(".t_subtotal").text(sub_total);
            $(".t_discount").text(discount_price);
            $(".t_g_total").text(sub_total - discount_price);

        } // get sum total price of all
        
        $("#bk_form").on('submit', function(){
            var av_room = $("#available_room").val();
            var select_room = $("#select_room").val();
            if(parseInt(select_room) > av_room){
                alert("Sorry, you select maxinum number of room");
                return false;
            } // if check room validate

            var nmbr_persion = $("#nmbr_persion").val();
            var total_adult = $("#total_adult").val();
            if(parseInt(nmbr_persion) > parseInt(total_adult)){
                alert("Sorry, you select maxinum number of room");
                return false;
            }// if check persion and total adult validate

        })

    });
</script>

@endsection