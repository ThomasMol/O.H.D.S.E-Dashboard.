<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('login');
    }

    public function authenticate(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        if(Auth::attempt(['email'=>$email, 'password'=>$password])){
            //return auth()->user();
            return redirect('/');
        }else{
            return redirect('/login')->witherrors('Email of wachtwoord fout, probeer opnieuw.');
        }

    }

}
