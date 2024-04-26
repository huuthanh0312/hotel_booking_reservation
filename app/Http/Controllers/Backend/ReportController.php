<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Bookig Report methods
    public function BookingReport(){


        return view('backend.report.booking_report');
    }

    public function SearchByDate(Request $request){
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $bookings = Booking::where('check_in', '>=', $start_date)
                                ->where('check_out', '<=', $end_date)->get();

        return view('backend.report.booking_search_report', compact('bookings', 'start_date', 'end_date'));
    }
}
