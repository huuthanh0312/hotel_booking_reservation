<?php

namespace App\Http\Controllers\Frontend;

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
use Barryvdh\DomPDF\Facade\Pdf;


class BookingController extends Controller
{
    //Booking methods
    public function Checkout(){

        if(Session::has("book_date")){
            $book_data = Session::get('book_date');

            $room = Room::find($book_data['room_id']);
            $toDate = Carbon::parse($book_data['check_in']);
            $FromDate = Carbon::parse($book_data['check_out']);
            $nights = $toDate->diffInDays($FromDate);
            return view('frontend.checkout.checkout', compact('book_data', 'room', 'nights'));

        } else{
            $notification = array(
                'message'=> 'Something want to worng',
                'alert-type' => 'error'
            );
            return redirect('/')->with($notification);
        }

        
    }// end methods

    public function BookingStore( Request $request){
        $validateData = $request->validate([
            'check_in'=> 'required',
            'check_out'=> 'required',
            'persion'=> 'required',
            'number_of_rooms'=> 'required',
            
        ]);

        if($request->available_room < $request->number_of_rooms){
            $notification = array(
                'message'=> 'Something want to worng',
                'alert-type' => 'error'
            );
            return redirect()->back()->notification($notification);
        }

        Session::forget('book_date');

        $data = array();
        $data['number_of_rooms'] = $request->number_of_rooms;
        $data['available_room'] = $request->available_room;
        $data['persion'] = $request->persion;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in)) ;
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out)) ;
        
        $data['room_id'] = $request->room_id ;

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }// end methods

    // Check Out Store
    public function CheckoutStore(Request $request){
        $this->validate($request, [
            'name'=> 'required',
            'email'=> 'required',
            'country'=> 'required',
            'phone'=> 'required',
            'address'=> 'required',
            'state'=> 'required',
            'zip_code'=> 'required',
            'payment_method'=> 'required',
            
        ]);
        $book_data = Session::get('book_date');
        
        $toDate = Carbon::parse($book_data['check_in']);
        $FromDate = Carbon::parse($book_data['check_out']);
        $total_nights = $toDate->diffInDays($FromDate);

        $room = Room::find($book_data['room_id']);  
        $sub_total = $room->price * $total_nights * $book_data['number_of_rooms'];
        $discount = ($room->discount/100) * $sub_total;
        $total_price = $sub_total - $discount;
        $code = rand(000000000, 999999999);

        // add data bookng
        $data = new Booking();
        $data->rooms_id = $book_data['room_id'];
        $data->user_id = Auth::user()->id;

        $data->check_in = date('Y-m-d', strtotime($book_data['check_in']));
        $data->check_out = date('Y-m-d', strtotime($book_data['check_out']));
        $data->persion = $book_data['persion'] ;
        $data->number_of_rooms = $book_data['number_of_rooms'];
        $data->total_night = $total_nights;

        $data->actual_price = $room->price;
        $data->subtotal = $sub_total;
        $data->discount = $discount;
        $data->total_price = $total_price;
        $data->payment_method = $request->payment_method;
        if($request->payment_method == 'Stripe'){
            Stripe\Stripe::setApiKey(ENV('STRIPE_SECRET'));
            $s_pay = Stripe\Charge::create([
                "amount" => $total_price * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Payment For Booking. Booking No ".$code,
            ]);
            if($s_pay['status'] == 'succeeded'){
                $data->transaction_id = $s_pay->id;
                $data->payment_status = 1;
            }
        }else{
            $data->transaction_id = '';
            $data->payment_status = 0;
        }
       
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
        $sdate = date('Y-m-d', strtotime($book_data['check_in'])); //get data date check in and custom
        $edate = date('Y-m-d', strtotime($book_data['check_out'])); //get data date check out and custom
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
        return redirect('/')->with($notification);

    }// end methods

    // Admin Booking Request 
    public function BookingList() {
        $allData = Booking::orderBy('id', 'desc')->get();

        return view('backend.booking.booking_list', compact('allData'));
    }// end methods
    
    // Info Edit Booking
    public function EditBooking( $id ) {
        $editData = Booking::with('room')->find($id);

        return view('backend.booking.edit_booking', compact('editData'));
    }// end methods

    // Update Booking Status
    public function UpdateBookingStatus(Request $request, $id){
        $booking = Booking::find($id);
        $booking->payment_status = $request->payment_status;
        $booking->status = $request->status;
        $booking->save();

        $notification = array(
            'message'=> 'Infomation Booking Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }// end methods

    //Update Booking Admin
    public function UpdateBooking(Request $request, $id){
        if($request->available_room < $request->number_of_rooms){
            $notification = array(
                'message'=> 'Something Warn To Worng!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $data = Booking::find($id);
        $data->number_of_rooms = $request->number_of_rooms;
        $data->check_in = date('Y-m-d', strtotime($request->check_in));
        $data->check_out = date('Y-m-d', strtotime($request->check_out));

        $data->save();
        BookingRoomList::where('booking_id', $id)->delete();
        RoomBookedDate::where('booking_id', $id)->delete();
        // add booking dated data 
        $sdate = date('Y-m-d', strtotime($request->check_in)); //get data date check in and custom
        $edate = date('Y-m-d', strtotime($request->check_out)); //get data date check out and custom
        $eldate = Carbon::create($edate)->subDay();

        $d_period = CarbonPeriod::create($sdate, $eldate); //get array day 2024-4-6/2024-4-7/2024-4-8/

        foreach($d_period as $period){
            $book_dates = new RoomBookedDate();
            $book_dates->booking_id = $data->id;
            $book_dates->rooms_id = $data->rooms_id;
            $book_dates->book_date = date('Y-m-d', strtotime($period));
            $book_dates->save();
        }
        $notification = array(
            'message'=> 'Updated Booking Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);


    }// end methods


    // assign room
    public function AssignRoom($booking_id){
        $booking = Booking::find($booking_id);
        $booking_date_array = RoomBookedDate::where('booking_id', $booking_id)->pluck('book_date')->toArray();

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $booking_date_array)
                                ->where('rooms_id', $booking->rooms_id)->distinct()->pluck('booking_id')->toArray();
        $booking_ids = Booking::whereIn('id', $check_date_booking_ids)->pluck('id')->toArray();
        
        $assign_room_ids = BookingRoomList::whereIn('booking_id', $booking_ids)->pluck('room_number_id')->toArray();

        $room_numbers = RoomNumber::where('rooms_id', $booking->rooms_id)->whereNotIn('id', $assign_room_ids)
                                ->where('status', 'active')->get();

        return View('backend.booking.assign_room', compact('booking', 'room_numbers'));
    }// end methods

    // assign room store
    public function AssignRoomStore($booking_id, $room_number_id){
        $booking = Booking::find($booking_id);
        
        $check_room_list = BookingRoomList::where('booking_id', $booking_id)->count();

        if($check_room_list < $booking->number_of_rooms){
            $assign_data = new BookingRoomList();
            $assign_data->booking_id = $booking_id;
            $assign_data->rooms_id = $booking->rooms_id;
            $assign_data->room_number_id = $room_number_id;
            $assign_data->save();

            $notification = array(
                'message'=> 'Room Assign Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else{
            $notification = array(
                'message'=> 'Something Warn To Worng!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        
    }// end methods

    // Delete Assign Room
    public function AssignRoomDelete($id){
        $assign_room = BookingRoomList::find($id);
        $assign_room->delete();
        $notification = array(
            'message'=> 'Deleted Room Assign Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// end methods


    //--------------- PDF ----------------//
    public function DownloadInvoice($id){
        $editData = Booking::with('room')->find($id);
        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('editData'))
                    ->setOption('a4')->setOption([
                        'tempDir' => public_path(),
                        'chroot' => public_path(),
                    ]);
        return $pdf->download('invoice.pdf');

    }// end methods
}// end methods
