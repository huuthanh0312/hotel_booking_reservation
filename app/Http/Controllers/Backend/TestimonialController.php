<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TestimonialController extends Controller
{
    // Testimonial Route Methods
    public function AllTestimonial(){
        $testimonials = Testimonial::latest()->get();
        return view('backend.testimonial.all_testimonial', compact('testimonials'));
    } // end methods
    public function AddTestimonial(){
        
        return view('backend.testimonial.add_testimonial');
    } // end methods

    // Add Data Team 
    public function StoreTestimonial(Request $request){ 
        $image_name = '';
        //upload file photo
        if($request->file('image')){
            $file = $request->file('image');
            $image_name = date('YmdHi').'_testimonial.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/testimonial'), $image_name);
            
        }
        Testimonial:: insert([
            'name'=> $request->name,
            'city'=> $request->city,
            'message'=> $request->message,
            'image' => 'upload/testimonial/'.$image_name,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Testimonial Data Inserted  Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('testimonial.all')->with($notification);
      }

      // Edit Team controller
      public function EditTestimonial($id){
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonial.edit_testimonial', compact('testimonial'));
      }

      public function UpdateTestimonial(Request $request){
        $data = Testimonial::find($request->id);
        $data->name = $request->name;
        $data->city = $request->city;
        $data->message = $request->message;
        //upload file photo
        if($request->file('image')){
            $file = $request->file('image');
            @unlink(public_path($data->image));
            $filename = date('YmdHi').'_testimonial.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/testimonial'), $filename);
            $data['image'] = 'upload/testimonial/'.$filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'Testimonial Testimonial Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('testimonial.all')->with($notification);
      }

      public function DeleteTeam($id){
            $item = Testimonial::findOrFail( $id);
            
            if($item->image){
                @unlink(public_path($item->image));
            }
            Testimonial::findOrFail($id)->delete();
            $notification = array(
                'message'=> 'Delete Testimonial Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
      }
}
