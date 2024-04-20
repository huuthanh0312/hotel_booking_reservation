<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BookingRoomList;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\RoomBookedDate;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Booking;
use App\Models\RoomType;
use Stripe;

class RoomListController extends Controller
{
    //Room List methods
    public function ViewRoomList(){
        $room_number_list = RoomNumber::with(['room_type', 'last_booking.booking:id,check_in,check_out,status,code,name,phone'])->orderBy('room_type_id', 'asc')
            ->leftJoin('room_types', 'room_types.id', 'room_numbers.room_type_id')
            ->leftJoin('booking_room_lists', 'booking_room_lists.room_number_id', 'room_numbers.id')
            ->leftJoin('bookings', 'bookings.id', 'booking_room_lists.booking_id')
            ->select(
                'room_numbers.*',
                'room_numbers.id as id',
                'room_types.name',
                'bookings.check_in',
                'bookings.check_out',
                'bookings.id as booking_id',
                'bookings.name as customer_name',
                'bookings.phone as customer_phone',
                'bookings.status as booking_status',
                'bookings.code as booking_no',
            )
            ->orderBy('room_types.id', 'asc')
            ->orderBy('bookings.id', 'desc')
            ->get();
                //dd($room_number_list);
        return view('backend.allroom.roomlist.view_roomlist', compact('room_number_list'));
    }//end methods

    //Add room list 
    public function AddRoomList(){
        $roomtype = RoomType::all();
        return view('backend.allroom.roomlist.add_roomlist', compact('roomtype'));
    }//end methods

    // Add Guest Room List
    public function StoreRoomList(Request $request){
        if($request->check_in == $request->check_out){
            $request->flash();
            $notification = array(
                'message'=> 'You Enter Same Date',
                'alert-type'=> 'error'
            );
            return redirect()->back()->with($notification);
        }
        if($request->available_room < $request->number_of_rooms){
            $request->flash();
            $notification = array(
                'message'=> 'You Enter Maxing Number Of Rooms',
                'alert-type'=> 'error'
            );
            return redirect()->back()->with($notification);
        }

        $room = Room::find($request['room_id']);
        if($room->room_capacity < $request->number_of_persion){
            // $request->flash();
            $notification = array(
                'message'=> 'You Enter Maxing Number Of Guest',
                'alert-type'=> 'error'
            );
            return redirect()->back()->with($notification);
        }
       
        
        $toDate = Carbon::parse($request['check_in']);
        $FromDate = Carbon::parse($request['check_out']);
        $total_nights = $toDate->diffInDays($FromDate);

        $room = Room::find($request['room_id']);  
        $sub_total = $room->price * $total_nights * $request->number_of_rooms;
        $discount = ($room->discount/100) * $sub_total;
        $total_price = $sub_total - $discount;
        $code = rand(000000000, 999999999);

        // add data bookng
        $data = new Booking();
        $data->rooms_id = $room->id;
        $data->user_id = Auth::user()->id;

        $data->check_in = date('Y-m-d', strtotime($request['check_in']));
        $data->check_out = date('Y-m-d', strtotime($request['check_out']));
        $data->persion = $request->number_of_persion;
        $data->number_of_rooms = $request->number_of_rooms;
        $data->total_night = $total_nights;

        $data->actual_price = $room->price;
        $data->subtotal = $sub_total;
        $data->discount = $discount;
        $data->total_price = $total_price;
        $data->payment_method = 'COD';
        $data->payment_status = 0;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->country = $request->country;
        $data->address = $request->address;
        $data->state = $request->state;
        $data->zip_code = $request->zip_code;

        $data->code = $code;
        $data->status = 0;
        $data->created_at = Carbon::now();

        $data->save();
        
        // add booking dated data 
        $sdate = date('Y-m-d', strtotime($request['check_in'])); //get data date check in and custom
        $edate = date('Y-m-d', strtotime($request['check_out'])); //get data date check out and custom
        $eldate = Carbon::create($edate)->subDay();

        $d_period = CarbonPeriod::create($sdate, $eldate); //get array day 2024-4-6/2024-4-7/2024-4-8/
       
        foreach($d_period as $period){
            $book_dates = new RoomBookedDate();
            $book_dates->booking_id = $data->id;
            $book_dates->rooms_id = $room->id;
            $book_dates->book_date = date('Y-m-d', strtotime($period));
            $book_dates->save();
        }

        Session::forget('book_date');
        $notification = array(
            'message'=> 'Booking Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
