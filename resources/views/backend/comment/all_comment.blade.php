@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .large-checkbox{
        transform: scale(1.5);
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
                    <li class="breadcrumb-item active" aria-current="page">Data Comments</li>
                </ol>
            </nav>
        </div>
     
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">DataTable All Comments</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                    <thead >
                        <tr>
                            <th>SL</th>
                            <th>USER NAME</th>
                            <th>POST NAME</th>
                            <th>MESSAGE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $key => $com)
                          
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td>{{$com->user->name }}</td>
                            <td>{{Str::limit($com->post->post_title, 20)}}</td>
                            <td>{{Str::limit($com->message, 20)}}</td>
                            <td>
                                <div class="form-check-danger form-check form-switch ">
                                    <input type="checkbox" class="form-check-input status-toggle large-checkbox" id="flexSwitchCheckedDanger"
                                        data-comment-id="{{$com->id}}" {{$com->status ? 'checked' : ''}}>
                                    <label for="flexSwitchCheckedDanger" class="form-check-label"></label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('.status-toggle').on('change', function(){
            var commentId = $(this).data('comment-id');
            var isChecked = $(this).is(':checked');
            // send ajax request to update satus 

            $.ajax({
                url: "{{route('update.comment.status')}}",
                method: 'POST',
                data: {
                    comment_id: commentId,
                    is_checked: isChecked ? 1 : 0,
                    _token: "{{csrf_token()}}"
                },
                success: function(response){
                    toastr.success(response.message);
                },
                error: function(response){
                    toastr.error(response.message);
                }
            })
        })
        
    })
</script>
@endsection