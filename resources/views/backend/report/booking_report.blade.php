@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i
                                class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Booking Report</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->
    <hr />

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('search-by-date')}}" method="post" id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row p-2">

                        <div class="col-md-6 p-2">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" />
                            @if ($errors->has('start_date'))
                            <p class="text-danger">{{$errors->first('start_date')}}</p>
                            @endif
                        </div>

                        <div class="col-md-6 p-2">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" />
                            @if ($errors->has('end_date'))
                            <p class="text-danger">{{$errors->first('end_date')}}</p>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-secondary">
                                <input type="submit" class="btn btn-primary px-4" value="Search" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>



@endsection