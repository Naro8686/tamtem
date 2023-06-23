<?php

namespace App\Http\Controllers\Client\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use App\Services\User\UserService;

use App\Traits\ApiControllerTrait;
use App\Traits\RedirectsUsers;

use Illuminate\Support\Facades\Validator;

use App\Http\Requests\Client\Api\v1\Register\RegisterRequest;
use App\Models\PointPerEvent;

class RegisterController extends Controller
{
  
    use ApiControllerTrait;
    use RedirectsUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
    * @var UserService
    */
    private $userService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {

        try{

            $from_agent = (true === $request->has('agent_id')) ?  $request->get('agent_id')  : null; 
            if($from_agent){
                $request->merge(['from_agent' => $this->userService->getRowValue('unique_id', $from_agent )->id]);
            }
            else{
                $request->merge(['from_agent' => null]);
            }

            event(new Registered($user = $this->userService->create($request->all())));

            $user->notify(new \App\Notifications\UserRegistered());

            return $this->successResponse($user);

        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Юзер  шлет повторное письмо для подтверждения емейл
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function repeateRegisterMailSend(Request $request)
     {
 
         $v = Validator::make($request->all(), [
             'email' => 'required|exists:users,email',
         ]);
 
         if ($v->fails())
         {
             return $this->errorResponse($v->errors());
         }
        
         $email = $request->email;
 
         $user = User::where('email', $email)->get()->first();

         if($user->status !== User::USER_STATUS_REGISTRED){
               return $this->errorResponse();
         }

         $user->notify(new \App\Notifications\UserRegistered());

         return $this->successResponse();

     }
     /**
     *  Подтверждение регистрации email
     * 
     * registerConfirm
     *
     * @param  mixed $request
     * @param  mixed $token
     *
     * @return void
     */
    public function registerConfirm(Request $request, $token)
    { 
        if ($user = $this->userService->setUserRegistered($token)) {

            // начислим баллы, если переход по рефералке
            if ($user and $user->from_agent !== null){
                // кол-во баллов за событие
                $pountPerEvent = PointPerEvent::select('event_name', 'point')->get()->keyBy('event_name')->toArray();

                // баллы для агента. который зарегался по рефералке
                $points_from_agents_to_registered_agent = (isset($pountPerEvent['points_from_agents_to_registered_agent']['point'] )) ? $pountPerEvent['points_from_agents_to_registered_agent']['point'] : 100;
                    $user->points_from_agents += $points_from_agents_to_registered_agent;
                    $user->points += $points_from_agents_to_registered_agent;
                    // обновим балланс юзера в его кабинете, количество баллов и его привилегии
                    $user->privilege_id = \App\Models\Privileges::where('point', '<=', $user->points)->orderBy('point', 'DESC')->first()->id;                   
                    $user->save();

                // баллы для агента, по чьей ссылке перешли
                $points_from_agents_to_agent = (isset($pountPerEvent['points_from_agents_to_agent']['point'] )) ? $pountPerEvent['points_from_agents_to_agent']['point'] : 30;
                    $user_agent = $this->userService->get($user->from_agent);
                    if($user_agent instanceof User){
                        $user_agent->points_from_agents += $points_from_agents_to_agent;
                        $user_agent->points += $points_from_agents_to_agent;
                        // обновим балланс юзера в его кабинете, количество баллов и его привилегии
                        $user_agent->privilege_id = \App\Models\Privileges::where('point', '<=', $user_agent->points)->orderBy('point', 'DESC')->first()->id;   
                        $user_agent->save();
                    }

            }
            return redirect('/?registration=true');
            //return redirect('/')->withCookie(cookie('api_auth', $api_token, 0));
        }
       
        return redirect('/?registration=false');
    }


     /**
     * Переход на этот сайт по реферальной ссылке и передача параметров в главный блейд
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function referalLinkEnter($data)
    {
        try{

            $data = base64_decode($data);

            $parts = parse_url($data); 
            parse_str($parts['path'], $query);
            $validator = Validator::make($query, [
                'agent_id' => 'required|exists:users,unique_id',
            ]);
            if ($validator->fails()) {
                return redirect('/');
            }

            return redirect('/?destination=regagent&agent=' . $query['agent_id']);

        }
        catch(Throwable $e){
            return redirect('/');
        }
    }
}
