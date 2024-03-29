@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Room</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Rooms Edit</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('room.type.list')}}" class="btn btn-outline-primary px-5 radius-30">Room Type List</a>

            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <h6 class="mb-0 text-uppercase text-center">Update Room</h6>
            <hr />
            <div class="row row-cols-1 row-cols-md-1">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-primary" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                        aria-selected="true">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-home font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Manager Room</div>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                                        aria-selected="false">
                                        <div class="d-flex align-items-center">
                                            <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                            </div>
                                            <div class="tab-title">Room Number</div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content py-3">
                                <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                    <div class=" p-4">
                                        <h5 class="mb-4">Room Form</h5>
                                        <form class="row g-3" action="{{ route('room.update', $editRoom->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-4">
                                                <label for="input1" class="form-label">Room Type Name</label>
                                                <input type="text" class="form-control" id="roomtype_id"
                                                    name="roomtype_id" value="{{$editRoom['type']['name']}}" >
                                            </div>
                                            <div class="col-md-4">
                                                <label for="input2" class="form-label">Total Adult</label>
                                                <input type="text" class="form-control" id="input2" name="total_adult"
                                                    value="{{$editRoom->total_adult}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="input2" class="form-label">Total Child</label>
                                                <input type="text" class="form-control" id="input2" name="total_child"
                                                    value="{{$editRoom->total_child}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="image" class="form-label">Main Image</label>
                                                <input type="file" name="image" class="form-control" id="image"
                                                    placeholder="image">
                                                <div class="text-secondary pt-2">
                                                    <img id="showImage" src="{{ !(empty($editRoom->image)) ? url($editRoom->image) :
                                                                url('/upload/no_image.jpg')}}"
                                                        class="rounded-circle p-1 bg-primary" width="80">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="multiImg" class="form-label">Gallery Image</label>
                                                <input type="file" name="multi_img[]" class="form-control" id="multiImg"
                                                    placeholder="image" accept="image/jpeg, image/png, image/gif, image/jpg" multiple>
                                                <br>
                                                {{-- Show multi images --}}
                                                @foreach ($multi_image as $item)
                                                <img src="{{ !(empty($item->multi_img)) ? url($item->multi_img) : url('/upload/no_image.jpg')}}"
                                                    class=" p-1 bg-primary" width="80">
                                                <a href="{{route('multi.image.delete', $item->id)}}"><i class="lni lni-close"></i></a>
                                                @endforeach
                                                {{-- end show --}}
                                                <div class="row" id="preview_img"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="price" class="form-label">Room Price</label>
                                                <input type="text" class="form-control" id="price" name="price"
                                                    value="{{$editRoom->price}}" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="size" class="form-label">Room Size</label>
                                                <input type="text" class="form-control" id="size" name="size"
                                                    value="{{$editRoom->size}}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="discount" class="form-label">Room Dicount ( % )</label>
                                                <input type="text" class="form-control" id="discount" name="discount"
                                                    value="{{$editRoom->discount}}" >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="room_capacity" class="form-label">Room Capacity</label>
                                                <input type="text" class="form-control" id="room_capacity" name="room_capacity"
                                                    value="{{$editRoom->room_capacity}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="view" class="form-label">Room View</label>
                                                <select name="view" id="view" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option value="Sea View" {{$editRoom->view == 'Sea View' ? 'selected':''}}>Sea View</option>
                                                    <option value="Hill View" {{$editRoom->view == 'Hill View' ? 'selected':''}}>Hill View</option>

                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="bed_style" class="form-label">Bed Style</label>
                                                <select name="bed_style" id="bed_style" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option value="Queen Bed" {{$editRoom->bed_style == 'Queen Bed'?'selected':''}}>Queen Bed</option>
                                                    <option value="Twin Bed" {{$editRoom->bed_style == 'Twin Bed'?'selected':''}}>Twin Bed</option>
                                                    <option value="King Bed" {{$editRoom->bed_style == 'King Bed'?'selected':''}}>King Bed</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input11" class="form-label">Short Description</label>
                                                <textarea class="form-control" id="input11" name="short_desc"
                                                    placeholder="Short Descrption ..."
                                                    rows="3">{{ $editRoom->short_desc}}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="myeditor" class="form-label">Description</label>
                                                <textarea class="form-control" id="myeditor" name="description"
                                                    placeholder=" Descrption ..."
                                                    rows="5">{{ $editRoom->short_desc}}</textarea>
                                            </div>
                                            {{-- facility --}}
                                            <div class="row mt-2">
                                                <div class="col-md-12 mb-3">
                                                    @forelse ($basic_facility as $item)
                                                    <div class="basic_facility_section_remove"
                                                        id="basic_facility_section_remove">
                                                        <div class="row add_item">
                                                            <div class="col-md-8">
                                                                <label for="facility_name" class="form-label"> Room
                                                                    Facilities </label>
                                                                <select name="facility_name[]" id="facility_name"
                                                                    class="form-control">
                                                                    <option value="">Select Facility</option>
                                                                    <option value="Complimentary Breakfast" {{$item->
                                                                        facility_name == 'Complimentary Breakfast'?'selected':''}}>Complimentary
                                                                        Breakfast</option>
                                                                    <option value="32/42 inch LED TV" {{$item->
                                                                        facility_name == '32/42 inch LED TV'?'selected':''}}> 32/42 inch LED TV
                                                                    </option>

                                                                    <option value="Smoke alarms" {{$item->facility_name
                                                                        == 'Smoke alarms'?'selected':''}}>Smoke alarms
                                                                    </option>

                                                                    <option value="Minibar" {{$item->facility_name == 'Minibar'?'selected':''}}>
                                                                        Minibar</option>

                                                                    <option value="Work Desk" {{$item->facility_name ==
                                                                        'Work Desk'?'selected':''}}>Work Desk</option>

                                                                    <option value="Free Wi-Fi" {{$item->facility_name ==
                                                                        'Free Wi-Fi'?'selected':''}}>Free Wi-Fi</option>

                                                                    <option value="Safety box" {{$item->facility_name ==
                                                                        'Safety box'?'selected':''}} >Safety box
                                                                    </option>

                                                                    <option value="Rain Shower" {{$item->facility_name
                                                                        == 'Rain Shower'?'selected':''}} >Rain Shower
                                                                    </option>

                                                                    <option value="Slippers" {{$item->facility_name ==
                                                                        'Slippers'?'selected':''}} >Slippers</option>

                                                                    <option value="Hair dryer" {{$item->facility_name ==
                                                                        'Hair dryer'?'selected':''}} >Hair dryer
                                                                    </option>

                                                                    <option value="Wake-up service" {{$item->
                                                                        facility_name == 'Wake-up service'?'selected':''}}>Wake-up service
                                                                    </option>

                                                                    <option value="Laundry & Dry Cleaning" {{$item->
                                                                        facility_name == 'Laundry & Dry Cleaning'?'selected':''}} >Laundry & Dry
                                                                        Cleaning</option>

                                                                    <option value="Electronic door lock" {{$item->
                                                                        facility_name == 'Electronic door lock' ? 'selected':''}}>Electronic door lock
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group" style="padding-top: 30px;">
                                                                    <a class="btn btn-success addeventmore"><i
                                                                            class="lni lni-circle-plus"></i></a>
                                                                    <span
                                                                        class="btn btn-danger btn-sm removeeventmore"><i
                                                                            class="lni lni-circle-minus"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @empty

                                                    @endforelse

                                                </div>
                                            </div>
                                            <br>
                                            {{-- end spactities --}}
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Saves
                                                        Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                    <div class=" p-4">
                                        <h5 class="mb-4">Vertical Form</h5>
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label for="input1" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="input1"
                                                    placeholder="First Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="input2" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="input2"
                                                    placeholder="Last Name">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input3" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="input3" placeholder="Phone">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input4" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="input4"
                                                    placeholder="Email">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input5" class="form-label">Password</label>
                                                <input type="password" class="form-control" id="input5"
                                                    placeholder="Password">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input6" class="form-label">DOB</label>
                                                <input type="date" class="form-control" id="input6"
                                                    placeholder="Date of Birth">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input7" class="form-label">Country</label>
                                                <select id="input7" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option>One</option>
                                                    <option>Two</option>
                                                    <option>Three</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="input8" class="form-label">City</label>
                                                <input type="text" class="form-control" id="input8" placeholder="City">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="input9" class="form-label">State</label>
                                                <select id="input9" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option>One</option>
                                                    <option>Two</option>
                                                    <option>Three</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="input10" class="form-label">Zip</label>
                                                <input type="text" class="form-control" id="input10" placeholder="Zip">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="input11" class="form-label">Address</label>
                                                <textarea class="form-control" id="input11" placeholder="Address ..."
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="input12">
                                                    <label class="form-check-label" for="input12">Check me
                                                        out</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="button" class="btn btn-primary px-4">Submit</button>
                                                    <button type="button" class="btn btn-light px-4">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--end row-->
</div>


<!--========== Start of add Basic Plan Facilities ==============-->
<div style="visibility: hidden">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="basic_facility_section_remove" id="basic_facility_section_remove">
            <div class="container mt-2">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="facility_name">Room Facilities</label>
                        <select name="facility_name[]" id="facility_name" class="form-control">
                            <option value="">Select Facility</option>
                            <option value="Complimentary Breakfast">Complimentary Breakfast</option>
                            <option value="32/42 inch LED TV"> 32/42 inch LED TV</option>
                            <option value="Smoke alarms">Smoke alarms</option>
                            <option value="Minibar"> Minibar</option>
                            <option value="Work Desk">Work Desk</option>
                            <option value="Free Wi-Fi">Free Wi-Fi</option>
                            <option value="Safety box">Safety box</option>
                            <option value="Rain Shower">Rain Shower</option>
                            <option value="Slippers">Slippers</option>
                            <option value="Hair dryer">Hair dryer</option>
                            <option value="Wake-up service">Wake-up service</option>
                            <option value="Laundry & Dry Cleaning">Laundry & Dry Cleaning</option>
                            <option value="Electronic door lock">Electronic door lock</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6" style="padding-top: 20px">
                        <span class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></span>
                        <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
       var counter = 0;
       $(document).on("click",".addeventmore",function(){
             var whole_extra_item_add = $("#whole_extra_item_add").html();
             $(this).closest(".add_item").append(whole_extra_item_add);
             counter++;
       });
       $(document).on("click",".removeeventmore",function(event){
             $(this).closest("#basic_facility_section_remove").remove();
             counter -= 1
       });
    });
</script>
<!--========== End of Basic Plan Facilities ==============-->

{{-- validate form --}}
{{-- <script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                         
            },
            messages :{
                name: {
                    required : 'Please Enter Room Type Name',
                }, 
                
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        }),
    });
    
 --}}
<!--------===Show MultiImage ========------->
<script>
    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(80); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
</script>
<script type="text/javascript">
    // ajax call image upload change img profile
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection