<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{
    //
    public function AdminDashboard(){
        return view('admin.index');
    }

    /**
     * Destroy an authenticated session.
     */
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }

    //Admin Login Controller
    public function AdminLogin(){
        return view('admin.admin_login');
    }
    //Show Admin Profile
    public function AdminProfile(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    //Add Inf and edit Profile Admin
    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        //upload file photo
        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message'=> 'Admin Profile Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    // Admin change Password
    public function AdminChangePassword(){   
        $id = Auth::user()->id; 
        $profileData = User::find($id); 
        return view('admin.admin_change_password', compact('profileData'));
    }

        // Admin change Password
    public function AdminPasswordUpdate(Request $request){   
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