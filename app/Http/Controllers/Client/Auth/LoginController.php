<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class LoginController extends Controller
{
    
   // use AuthenticatesUsers;

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

    use ApiControllerTrait;

    public function login(Request $request)
    { 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);

        if($user = User::where('email', $request->get('email'))->first()) {

            // не пускать забаненого
            if($user->isBanned()){
                response($this->errorResponse(['message' => "Отказано в доступе. Проверьте правильность ввода E-mail и пароля."]), 401);
            }
            
            $auth = Hash::check($request->get('password'), $user->password);

            if ($user && $user->status === User::USER_STATUS_REGISTRED) {
                return $this->errorResponse(['error_code' => User::USER_STATUS_REGISTRED, 
                                            'message' => "Вы не прошли процедуру подтверждения адреса своей электронной почты. Перейдите по ссылке в присланном вам письме или отправьте такое письмо повторно"]);
            }

            if ($user && ($user->role != User::ROLE_CLIENT && $user->role != User::ROLE_CLIENT_WORKER && $user->role != User::ROLE_ADMINISTRATOR)
                || $user->status != User::USER_STATUS_APPROVE) {
                return $this->accessDenied();
            }

            if($user && $auth) {
               // $user->rollApiKey();
                // return $this->successResponse([
                //     'api_token' => $user->api_token,
                // ]);
                $api_token = $user->login();
                return $this->successResponse([
                    'api_token' => $user->api_token,
                ]);
 //               return view('home', ['api_token' => $api_token]);
            }

        }

        return response($this->errorResponse(['message' => "Отказано в доступе. Проверьте правильность ввода E-mail и пароля."]), 401);
    }
}
