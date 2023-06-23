<?php

namespace  App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Traits\ApiControllerTrait;
use App\Traits\RedirectsUsers;

class ResetPasswordController extends Controller
{

    use ApiControllerTrait;
    use RedirectsUsers;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($v->fails())
        {
            return $this->errorResponse($v->errors());
        }
       
        $email = $request->email;
        $new_password = str_random(6);
        $token = base64_encode( Hash::make($new_password)); 

        $user = User::where('email', $email)->get()->first();
        $user->reset_password_token = $token;
        $user->save();

        $user->notify(new \App\Notifications\UserResetPassword( $token,  $new_password));

        return $this->successResponse();
    }

    /**
     *  Пришли по ссылке из письма , чтобы сбросить пароль passwordResetConfirm
     *
     * @param  mixed $request
     * @param  mixed $token
     *
     * @return void
     */
    public function passwordResetConfirm(Request $request, $token)
    {
        try{
            $user = User::where('reset_password_token', $token)->get()->first();
            $newPassword = base64_decode($token);
            if ($user) {
                $user->password = $newPassword;
                $user->reset_password_token = null;
                $user->save();
            }
            else{
                return redirect($this->pathRedirectTo('/', false , $command = 'passwordresetconfirm', 'Токен для сброса пароля не действующий'));
                //return $this->errorResponse('Reset password token not valid');
            }
        }
        catch(\Exception $e){
            return redirect($this->pathRedirectTo('/', false , $command = 'passwordresetconfirm', $e->getMessage()));
            // return $this->errorResponse($e);
        }
        
        return redirect($this->pathRedirectTo('/', true , $command = 'passwordresetconfirm', 'Необходимо войти в систему с новым паролем'));
    }

}
