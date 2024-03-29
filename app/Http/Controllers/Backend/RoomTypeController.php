<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use App\Models\Room;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    //Room Type With Methods
    public function RoomTypeList(){
        $dataRoomType = RoomType::orderBy("id","desc")->get();  
        return view('backend/allroom/room_type/view_roomtype', compact('dataRoomType'));
    }

    public function RoomTypeAdd(){
        return view('backend/allroom/room_type/add_roomtype');

    }

    public function RoomTypeStore(Request $request){
        $roomtype_id = RoomType::insertGetId([
            'name' => $request->name,
            'created_at'=> Carbon::now(),
        ]);
        Room::insert([
            'roomtype_id' => $roomtype_id,
            'created_at'=> Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Add Room Type Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);

    }

    public function RoomTypeEdit($id){
        $dataRoomType = RoomType::findOrFail($id);  
        return view('backend/allroom/room_type/edit_roomtype', compact('dataRoomType'));
    }

    public function RoomTypeUpdate(Request $request){
        RoomType::findOrFail($request->id)->update([
            'name'=> $request->name,
            'updated_at'=> Carbon::now(),
        ]); 

        $notification = array(
            'message'=> 'Update Room Type Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('room.type.list')->with($notification);

    }

    public function RoomTypeDelete($id){
        RoomType::findOrFail($id)->delete(); 
        
        $notification = array(
            'message'=> 'Delete Room Type Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

}
