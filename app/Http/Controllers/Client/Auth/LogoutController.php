<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use Auth;

class LogoutController extends Controller
{
   
   // use AuthenticatesUsers;

   use ApiControllerTrait;

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



    public function logout(Request $request)
    { 
       if($user = Auth::user()){
            $user->logout();
       }

       return redirect('/login');
    }
}
