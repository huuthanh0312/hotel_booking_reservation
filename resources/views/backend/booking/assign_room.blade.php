<form action="" method="POST">
@csrf

    <table class="table">
        <tr>
            <th>Room Number</th>
            <th>Action</th>
        </tr>
        @foreach ($room_numbers as $item)
        <tr>
            <td>{{$item->room_no}}</td>
            <td>
                <a href="{{route('assign_room_store', [$booking->id, $item->id])}}" class="btn btn-outline-primary "> <i class="lni lni-circle-plus"></i></a>
            </td>
        </tr>
            
        @endforeach
    </table>




</form>