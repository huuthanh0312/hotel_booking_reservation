<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Gallery;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Gallery Methods
    public function AllGallery(){
        $galleries = Gallery::latest()->get();

        return view('backend.gallery.all_gallery', compact('galleries'));
    }// end methods

    
    public function AddGallery(){
        
        return view('backend.gallery.add_gallery');
    }// end methods


    public function StoreGallery(Request $request){
        if($request->file('photo_name')){
            $images = $request->file('photo_name');
            
            foreach($images as $image){
                
                $filename = date('YmdHi').'_gallery.'.$image->getClientOriginalName(); //2003.avatar-2
                $image->move(public_path('upload/gallery'), $filename);
                $image_name = 'upload/gallery/'.$filename;
                Gallery::insert([
                    'photo_name' => $image_name,
                    'created_at' => Carbon::now(),
                ]);
                
            }
            $notification = array(
                'message'=> 'Gallary Inserted Successfully',
                'alert-type'=> 'success'
            );
            return redirect()->route('gallery.all')->with($notification);
            
        } else{
            $notification = array(
                'message'=> 'Please Choose Photo Gallary',
                'alert-type'=> 'error'
            );
            return redirect()->back()->with($notification);
        }
        
    }// end methods


    public function EditGallery($id) {
        $gallery = Gallery::find($id);

        return view('backend.gallery.edit_gallery', compact('gallery'));
        
    }

    public function UpdateGallery(Request $request){
        if($request->file('photo_name')){
            $gallery = Gallery::find($request->id);
            $image = $request->file('photo_name');
            
            @unlink(public_path($gallery->photo_name));
            $filename = date('YmdHi').'_gallery.'.$image->getClientOriginalName(); //2003.avatar-2
            $image->move(public_path('upload/gallery'), $filename);
            $image_name = 'upload/gallery/'.$filename;
            
                
            $gallery->photo_name = $image_name;
            $gallery->save();
            $notification = array(
                'message'=> 'Gallary Updated Successfully',
                'alert-type'=> 'success'
            );
            return redirect()->route('gallery.all')->with($notification);
            
        }
        
    }// end methods

    public function DeleteGallery($id){
        $gallery = Gallery::find($id);
        if($gallery->photo_name){
            @unlink(public_path($gallery->photo_name));
        }
        
        $gallery->delete();
        $notification = array(
            'message'=> 'Gallery Deleted Successfully',
            'alert-type'=> 'success'
        );
        return redirect()->back()->with($notification);
        
    
    }// end methods



    ////////// Deleted Gallery Multiple
    public function DeleteGallaryMultiple(Request $request) {
        $selectItems = $request->input('selectItem', []);
        if($selectItems){
            foreach($selectItems as $itemId){
                $gallery = Gallery::find($itemId);
                if($gallery->photo_name){
                    @unlink(public_path($gallery->photo_name));
                }
                
                $gallery->delete();
            }
            $notification = array(
                'message'=> 'Seleted Gallery Deleted Successfully',
                'alert-type'=> 'success'
            );
        }else{
            $notification = array(
                'message'=> 'Please Choose Seleted Gallery ',
                'alert-type'=> 'error'
            );
        }
        
        return redirect()->back()->with($notification);
    }// end methods


    //////////////////Frontend Show Gallery Methods
    public function ShowGallery(){
        $galleries = Gallery::latest()->get();
        return view('frontend.gallery.show_gallery'   , compact('galleries'));
    }

    ////////////// Contact Us   /////////////// 
    public function ContactUs(){

        return view('frontend.contact.contact_us');
    }

    //// Contact from user to admin ////

    public function ContactStore(Request $request){
        Contact::insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message'=> 'Your Message Send Successfully',
            'alert-type'=> 'success'
        );
        return redirect()->back()->with($notification);

    }



    ////// >>>>> Admin Show Contact <<<< ////

    public function AdminContactMessage(){
        $contacts = Contact::latest()->get();
        return view('backend.contact.contact_message', compact('contacts'));
    }
}
