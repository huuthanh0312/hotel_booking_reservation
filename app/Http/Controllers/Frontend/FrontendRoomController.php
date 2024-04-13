<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\RoomBookedDate;
use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Booking;

class FrontendRoomController extends Controller
{
    //All room methods
    public function AllRoom(){
        $dataRoom = Room::latest()->get();
        return view('frontend.room.allrooms', compact('dataRoom'));

    }

    public function DetailsRoomPage($id){
        $detailsRoom = Room::findOrFail($id);
        $multiImage = MultiImage::where('rooms_id', $id)->get();
        $facility = Facility::where('rooms_id', $id)->get();

        $othersRoom = Room::where('id', '!=', $id)->orderBy('id', 'desc')->limit(2)->get();
        return view('frontend.room.details_room', compact('detailsRoom', 'multiImage', 'facility', 'othersRoom'));
    }


    /// Booking Search
    public function BookingSearch(Request $request){  
        $request->flash();  //send info if error of null
        if($request->check_in >= $request->check_out ){
            $notification = array(
                'message'=> 'Something want to worng',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }// check date request send server

        $sdate = date('Y-m-d', strtotime($request->check_in)); //get data date check in and custom
        $edate = date('Y-m-d', strtotime($request->check_out)); //get data date check out and custom
        $alldate = Carbon::create($edate)->subDay();

        $d_period = CarbonPeriod::create($sdate, $alldate); //get sum hour
        $dt_array = [];
        foreach($d_period as $period){
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }
        // dt_array laays ra mang so ngay room vd:  "2024-04-03" [1]=> string(10) "2024-04-04" [2]=> string(10) "2024-04-05" 

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)    // pluck : lấy ra bảng ghi booking id 
                                    ->distinct()->pluck('booking_id')->toArray();   //,distinct cho phép bạn ép buộc truy vấn trả về các kết quả phân biệt
        
        $rooms = Room::withCount('room_numbers')->where('status', 1)->get();

        return view('frontend.room.search_room', compact('rooms', 'check_date_booking_ids'));
    } //end function

    // Search Room Details
    public function SearchRoomDetails(Request $request, $id){
        $request->flash();
        $detailsRoom = Room::findOrFail($id);
        $multiImage = MultiImage::where('rooms_id', $id)->get();
        $facility = Facility::where('rooms_id', $id)->get();
        $room_id = $id;
        $othersRoom = Room::where('id', '!=', $id)->orderBy('id', 'desc')->limit(2)->get();
        return view('frontend.room.search_details_room', compact('detailsRoom', 'multiImage', 'facility', 'othersRoom', 'room_id'));

    }//end methods

    public function CheckRoomAvailablity(Request $request){


        $sdate = date('Y-m-d', strtotime($request->check_in)); //get data date check in and custom
        $edate = date('Y-m-d', strtotime($request->check_out)); //get data date check out and custom
        $alldate = Carbon::create($edate)->subDay();

        $d_period = CarbonPeriod::create($sdate, $alldate); //get sum hour
        $dt_array = [];
        foreach($d_period as $period){
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)  //,distinct cho phép bạn ép buộc truy vấn trả về các kết quả phân biệt
                                    ->distinct()->pluck('booking_id')->toArray(); // pluck : lấy ra bảng ghi booking id 
        
        $room = Room::withCount('room_numbers')->find($request->room_id);
        
        $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids )
                    ->where('rooms_id', $room->id)->get()->toArray();
        
        $total_book_room = array_sum( array_column($bookings,'assign_rooms_count')); // tong room
        
        $av_room = @$room->room_numbers_count-$total_book_room;

        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);

        $nights = $toDate->diffInDays($fromDate);

        return response()->json(['available_room'=>$av_room, 'total_nights'=>$nights]);
    }
}
