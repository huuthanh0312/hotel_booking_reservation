<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Models\Room;
use PHPUnit\Framework\Constraint\Count;
use Carbon\Carbon;

class RoomController extends Controller
{
    //Room methods
    public function RoomEdit($id){
        $basic_facility = Facility::where('rooms_id', $id)->get();
        $multi_image = MultiImage::where('rooms_id', $id)->get();
        $editRoom = Room::findOrFail($id);
        return view("backend.allroom.rooms.edit_rooms", compact("editRoom", "basic_facility", "multi_image"));

    }// end method
    // add room controller 
    public function RoomUpdate(Request $request, $id){
        // var_dump($request->basic_facility_name);
        // die();
        $room = Room::find($id);
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;  
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_desc = $request->short_desc;
        $room->description = $request->description;
        
        if($request->file('image')){
            $image = $request->file('image');
            // upload file image
            @unlink(public_path('upload/rooming/'.$room->image));
            $filename = date('YmdHi').'room.'.$image->getClientOriginalName(); //2003.avatar-2
            $image->move(public_path('upload/rooming'), $filename);
            $room['image'] = 'upload/rooming/'.$filename;
        }

        $room->save();
        //add facility table
        if($request->facility_name == NULL ){
            $notification = array(
                'message'=> 'Sorry! Not Any Bacsic Facility Select',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else{
            Facility::where('rooms_id', $id)->delete();
            $facilities = Count($request->facility_name);
            for( $i = 0; $i < $facilities; $i++){
                $fcount = new Facility();
                $fcount->rooms_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            } //end for 

        }

        // update multi images
        if($room->save()){
            $files = $request->multi_img;
            // var_dump($files);
            // die();
            if(!empty($files)){
                $subimage = MultiImage::where('rooms_id', $id)->get()->toArray(); 
            if(!empty($files)){
                foreach($files as $file){
                    $filename = date('YndHmi').'img_multi'.$file->getClientOriginalName();
                    $file->move(public_path('/upload/rooming/multi_img/'), $filename);
                    $submimage['multi_img'] = '/upload/rooming/multi_img/'.$filename;

                    $submimage = new MultiImage();
                    $submimage->rooms_id = $room->id;   
                    $submimage->multi_img = '/upload/rooming/multi_img/'.$filename;
                    $submimage->save();
                }
                }
            }//end if
        $notification = array(
            'message'=> 'Room Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
        }
    }// end method

    // delele multi image method
    public function MultiImageDelete($id){
        $deleteData = MultiImage::where('id', $id)->first();
        if($deleteData){
            $imagePath = $deleteData->multi_img;
            if(file_exists($imagePath)){
                unlink($imagePath);
                echo "Image Delete Successfully";
            }else {
                echo "Image does not exist";
            }
            // Delete the record form data img
            $deleteData->delete();
        }
        $notification = array(
            'message'=> 'Multi Image Deleted Successfully',
            'alert-type' => 'warning'
        );
        return redirect()->back()->with($notification);
    }
}
