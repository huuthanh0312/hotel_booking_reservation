<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\MultiImage;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Models\Room;

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
}
