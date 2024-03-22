<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    // home routes
    public function Index(){
        return view("frontend.index");
    }
    // profile 
    public function UserProfile(){ 
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('profileData'));   
    }
    public function ProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        //upload file photo
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'User Profile Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    //Logout
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message'=> 'Logout Successfully',
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notification);
    }

    // Admin change Password
    public function UserChangePassword(){   
        
        return view('frontend.dashboard.user_change_password');
    }

        // Admin change Password
    public function UserPasswordUpdate(Request $request){   
        //validation
        $request->validate([
            'old_password'=> 'required',
            'new_password' => 'required|confirmed',
        ]);
        if(!Hash::check($request->old_password, Auth::user()->password)){
            $notification = array(
                'message'=> 'Old Password Does not match',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        //update the new password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),   
        ]);
        $notification = array(
            'message'=> 'Update Password Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
