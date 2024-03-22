@extends('frontend.main_master')
@section('main')

<!-- Inner Banner -->
<div class="inner-banner inner-bg6">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{url('/')}}">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>User Dashboard </li>
            </ul>
            <h3>User Change Password</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Service Details Area -->
<div class="service-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                @include('frontend.dashboard.user_menu')
            </div>
            <div class="col-lg-9">
                <div class="service-article">
                    <section class="checkout-area pb-70">
                        <div class="container">
                            <form action="{{ route('password.change.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-details">
                                            <h3 class="title">User Change Password</h3>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-6">
                                                    <div class="form-group">
                                                        <label> Old Password <span class="required">*</span></label>
                                                        <input type="password" name="old_password" class="form-control" >
                                                        @error('old_password')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-6">
                                                    <div class="form-group">
                                                        <label> New Password <span class="required">*</span></label>
                                                        <input type="password" name="new_password" class="form-control" >
                                                        @error('new_password')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Confirm New Password <span class="required">*</span></label>
                                                        <input type="password" name="new_password_confirmation" class="form-control" >
                                                        @error('new_password_confirmation')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                                <button type="submit" name="submit" class="btn btn-danger">Save Changes </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        
                    </section>

                </div>
            </div>


        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection