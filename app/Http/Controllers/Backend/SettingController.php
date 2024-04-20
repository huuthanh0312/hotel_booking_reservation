<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
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
    
}
