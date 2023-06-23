<?php

namespace  App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Traits\ApiControllerTrait;
use App\Traits\RedirectsUsers;

use Auth;

class ChangePasswordController extends Controller
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
       // $this->middleware('guest')->except('logout');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('api')->user();

        $v = Validator::make($request->all(), [
            'password_old' => 'required|min:6|max:32',
            'password' => 'required|min:6|max:32',
        ]);

        if ($v->fails())
        {
            return $this->errorResponse($v->errors());
        }

        if (!$oldPassword = Hash::check($request->get('password_old'), $user->password)) {
            return response()->json($this->errorResponse([
                'errors' => ['password_old' => ['Вы не правильно ввели старый пароль.']]
            ]), 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

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
                return $this->errorResponse('Reset password token not valid');
            }
        }
        catch(\Exception $e){
            return $this->errorResponse($e);
        }
        
        return redirect('/login');
    }

}
