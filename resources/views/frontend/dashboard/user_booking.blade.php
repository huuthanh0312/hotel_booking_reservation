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
            <h3>User Booking List</h3>
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
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="billing-details">
                                        <h3 class="title">User Booking List</h3>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-6">
                                                <table class="table table-striped-columns">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">B No</th>
                                                            <th scope="col">B Date</th>
                                                            <th scope="col">Customer</th>
                                                            <th scope="col">Room</th>
                                                            <th scope="col">Check In/Out</th>
                                                            <th scope="col">Total Room</th>
                                                            <th scope="col">Guest</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($allData as $item)
                                                        <tr>
                                                            <th scope="row"><a href="{{route('user.invoice', $item->id)}}">{{$item->code}}</a></th>
                                                            <td>{{$item->created_at->format('d/m/Y')}}</td>
                                                            <td>{{$item['user']['name']}}</td>
                                                            <td>{{$item['room']['type']['name']}}</td>
                                                            <td><span class="badge bg-primary">{{$item->check_in}}</span>
                                                                 <br>
                                                                <span class="badge bg-warning">{{$item->check_out}}</span>
                                                            </td>
                                                            <td>{{$item->number_of_rooms}}</td>
                                                            <td>{{$item->persion}}</td>
                                                            <td>
                                                                @if ($item->status == 1)
                                                                    <span class="badge bg-success">Completed</span>
                                                                @else
                                                                <span class="badge bg-danger">Completed</span>
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
                            </div>
                        
                        </div>
                        
                    </section>

                </div>
            </div>


        </div>
    </div>
</div>
<!-- Service Details Area End -->

@endsection