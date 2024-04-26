<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    //SMTP Setting
    public function SmtpSetting (){
        $smtp = SmtpSetting::find(1);
        return view('backend.setting.smtp_update', compact('smtp'));
    }// end Methods
    public function UpdateSmtpSetting (Request $request){
        $smtp = SmtpSetting::find($request->id)->update([
            'mailer' => $request->mailer,
            'host' => $request->host,
            'port' => $request->port,
            'username' => $request->username,
            'password' => $request->password,
            'encryption' => $request->encryption,
            'from_address' => $request->from_address,
        ]);
        $notification = array(
            'message'=> 'Updated SMTP Setting Successfully',
            'alert-type'=> 'success'
        );
        return redirect()->back()->with($notification);
        
    }// end Methods

    //////////// SITE Setting /////////////
    public function SiteSetting (){
        $site = SiteSetting::find(1);
        return view('backend.setting.site_update', compact('site'));
    }// end Methods

    //update site setting
    public function UpdateSiteSetting (Request $request){
        $site = SiteSetting::find($request->id);
        //upload file photo
        if($request->file('logo')){
            $file = $request->file('logo');
            @unlink(public_path('upload/site/'.$site->logo));
            $filename = date('YmdHi').'_site.'.$file->getClientOriginalName(); //2003.avatar-2
            $file->move(public_path('upload/site'), $filename);
            $site['logo'] = 'upload/site/'.$filename;
        }
        $site->phone = $request->phone;
        $site->address = $request->address;
        $site->email = $request->email;
        $site->facebook = $request->facebook;
        $site->twitter = $request->twitter;
        $site->copyright = $request->copyright;
        $site->save();

        $notification = array(
            'message'=> 'Updated SITE Setting Successfully',
            'alert-type'=> 'success'
        );
        return redirect()->back()->with($notification);
        
    }// end Methods
    
}
