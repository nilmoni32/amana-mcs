<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }     

     /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request     
     */

    public function login(Request $request){
        // validate the form data.
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);
     
        // attempt to log the user in dashboard.
        // we are using web guard to filter users defined in config/auth.php
        // if the admin credentials(auth.login) is matched with user model then it is remembered the truthy value
        if(Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password ], $request->get('remember'))){
            // if successful, then redirect to their intended location.
            // here intended method is used to redirect the page is requested by admin user after successful login. 
            return redirect()->intended(route('dashboard'));
        } 
        // if unsuccessful, then redirect back to the login with the form data.
        else {            
            return redirect()->back()->withInput($request->only('email','remmember'));
        }
        
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }

    
}
