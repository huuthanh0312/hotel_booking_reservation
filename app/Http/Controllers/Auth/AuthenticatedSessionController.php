<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        
        $id = Auth::user()->id;
        $profileData = User::find($id);
        
        $url ='';
        if($request->user()->role === 'admin'){
            

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            $notification = array(
                'message'=> 'Please Access The Admin Link',
                'alert-type' => 'warning'
            );
            
            return redirect()->back()->with($notification);
        } elseif($request->user()->role === 'user'){
            
            $url = '/dashboard';
            $notification = array(
                'message'=> ''.$profileData->name.' Login Successfully',
                'alert-type' => 'info'
            );
            return redirect()->intended($url)->with($notification);
        }
        
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function AdminStore(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        

        $id = Auth::user()->id;
        $profileData = User::find($id);
        
        $url ='';
        if($request->user()->role === 'admin'){
            $request->session()->regenerate();
            $url = 'admin/dashboard';
            $notification = array(
                'message'=> ''.$profileData->name.' Login Successfully',
                'alert-type' => 'info'
            );
            return redirect()->intended($url)->with($notification);
        } elseif($request->user()->role === 'user'){
            
            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
            $notification = array(
                'message'=> 'Access Is Denied',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
