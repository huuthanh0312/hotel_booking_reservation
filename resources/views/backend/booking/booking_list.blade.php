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
                    <li class="breadcrumb-item active" aria-current="page">Data Booking</li>
                </ol>
            </nav>
        </div>
        
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Bookings</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                    <thead >
                        <tr>
                            <th>SL</th>
                            <th>B No</th>
                            <th>B Date</th>
                            <th>Customer</th>
                            <th>Room</th>
                            <th>Check IN/OUT</th>
                            <th>Total Room</th>
                            <th>Guest</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allData as $key => $item)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td><a href="{{route('edit_booking', $item->id )}}">{{$item->code}}</a></td>
                            <td>{{$item->created_at->format('Y-m-d')}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item['room']['type']['name']}}</td>
                            <td><span class="badge bg-primary">{{$item->check_in}}</span> / <span class="badge bg-warning text-dark">{{$item->check_out}}</span></td>
                            <td>{{$item->number_of_rooms}}</td>
                            <td>{{$item->persion}}</td>
                            <td>
                                @if ($item->payment_status == 1)
                                    <p class="text-primary">Completed</p>
                                @else
                                    <p class="text-danger">Pending</p>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 1)
                                    <p class="text-primary">Completed</p>
                                @else
                                    <p class="text-danger">Pending</p>
                                @endif
                            </td>
                            <td>
                                
                                <a href="{{ route('team.delete', $item->id)}}" id="delete" class="btn btn-outline-danger px-5 radius-30">Delete</a>
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