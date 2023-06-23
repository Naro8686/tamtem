<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use App\Models\User;

use App\Http\Requests\Client\Api\v1\Organization\GenerateReferalUrlRequest;
use App\Http\Requests\Client\Api\v1\User\GenerateReferalUrlForMeRequest;
use App\Services\Organization\OrganizationService;
use App\Models\Organization;

use App\Traits\ApiControllerTrait;
use Carbon\Carbon;
use Validator;
use Auth;
class ClientController extends Controller
{

    use ApiControllerTrait;

    /**
    * @var UserService
    */
    private $userService;

    /**
    * @var OrganizationService
    */
    private $organizationService;

    /**
    * @var authUser
    */
    private $authUser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, OrganizationService $organizationService)
    {
        $this->userService = $userService;
        $this->organizationService = $organizationService;
        $this->authUser = Auth::guard('api')->user();
    }


    public function index(Request $request)
    {
        return view('layouts.app');
    }

    /**
     * Получить профиль юзера по его токену 
     * 
     * @param  mixed $request
     *
     * @return void
     */
    public function getProfile(Request $request)
    {
        $user = $this->userService->get($this->authUser->id);

        if($user instanceof User){
            return $this->successResponse(new UserResource($user));
        }
        else{
            return $this->errorResponse($user);
        }
    }

    /**
     * Доступен ли ИНН для регистрации
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function innIsAvailable(Request $request, $isLocalRequest = false)
    {
        
        $validator = Validator::make($request->all(), [
            'inn' => 'required|min:10|max:12',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages());
        }

        $organization = Organization::where('inn', '=', $request->inn)->
                                      where('status', '=', Organization::ORGANIZATION_STATUS_ACTIVATED)->first();

        $returnVal = false;

        if($organization){
            $returnVal = ($isLocalRequest) ? false : $this->errorResponse();
        }
        else{

            // запросим еще и тамтем
            $respFromTamtem = $this->innIsAvailableFromTamtem($request->inn);//dd($isLocalRequest);
            if( $respFromTamtem  === null or $respFromTamtem === false){
                $returnVal = ($isLocalRequest) ? false : $this->errorResponse();
            }
            else if($respFromTamtem  === true){
                $returnVal = ($isLocalRequest) ? true : $this->successResponse();
            }
        }

        return $returnVal;
    }

      /**
     * Зарегистрирована ли компания с таким ИНН
     *
     * @return void
     */
    public function innIsAvailableFromTamtem($inn)
    {

        $URI = config('constants.tamtem.inn-is-available-api');
 
        $params = array (
            'inn' => $inn,
        );

        ////////////////////////////////////////////////////////

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $URI);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // указываем, что у нас POST запрос
        curl_setopt($ch, CURLOPT_POST, 1);
        // добавляем переменные
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        ///////////////////////////////////////////////////
     
        // если какая-то ошибка в механизме запросов
        if ($info['http_code'] !== 200 or $response === FALSE or strpos($response, 'ccess denied') !== false  ) {    
            return null;
        }

        $response = \json_decode($response); 
        
        if(isset($response->error)){
            return null;
        }

        return boolval($response->result);
    }

    /**
     * Генерирует реферальную ссылку, записывая в БД refGenerate
     *
     * @param  mixed $request
     * @param  mixed $isLocalRequest
     *
     * @return void
     */
    public function refGenerate(GenerateReferalUrlRequest $request, $isLocalRequest = false)
    {
        // если сгенерить ссылку нельзя для этого inn
        if($this->innIsAvailable($request, true) === false){
            return $this->errorResponse();
        }

        $dateGenerate = Carbon::now();

        $parametersToRefUrl = [
            'inn' => $request->inn,
            'agent_id' => ($isLocalRequest and $this->authUser->isAdmin()) ? $request->unique_id : $this->authUser->unique_id, // если админ генерит,то привяжем руками к юзеру по его unique_id
            'name' => $request->name,
            'date_generate' =>  $dateGenerate->format('Y-m-d H:i:s'),
        ];

        // если указали ссылку на зказ. то надо взять его номер, это последние цифры после слеша
        if(true === $request->has('bid')){
            $parametersToRefUrl['bid'] = $request->bid;
        }

        // найдем id юзера
        $userId = null;
        if(!$userId = $this->userService->getRowValue('unique_id', $parametersToRefUrl['agent_id'])){
            return $this->errorResponse('Не возможно найти пользователя с agent_id = ' . $parametersToRefUrl['agent_id']);
        }
        else{
            $userId = $userId->id;
        }
        
        $refToDbUrl = http_build_query($parametersToRefUrl);

        // { // разобрать пришедшие данные в url
        //     $parts = parse_url($refToDbUrl); 
        //     parse_str($parts['path'], $query);
        //     dd($query);
        //     // dd($refToDbUrl);
        // }

        $data = [
            'user_id'           => $userId,
            'inn'               => $parametersToRefUrl['inn'],
            'name'              => $parametersToRefUrl['name'],
            'status'            => Organization::ORGANIZATION_STATUS_UNACTIVATED,
            'parameters_url'    => $refToDbUrl,
            'referal_url'       => config('constants.tamtem.url') . '/ref/' . base64_encode($refToDbUrl),
            'before_to_at'      => $dateGenerate->addHours(72),
        ];

        $organization = null;
        // если уже есть пара user_id и Инн, то писать данные поверх, иначе создавать
        if($organization = Organization::where('inn', '=', $request->inn)->
                                         where('user_id', '=', $userId)->first()){

            $organization = $this->organizationService->update($organization->id, $data);
        }
        else{
            $organization = $this->organizationService->create($data);
        }

        if($organization instanceof Organization){
            $realRef = $organization->referal_url;
            return $this->successResponse($realRef);
        }
        else{
            return $this->errorResponse();
        }
    }


    /**
     * Генерация реферальной ссылки на самого агента и сохранение ее в БД
     *
     * @param  mixed $request
     * @param  mixed $isLocalRequest
     *
     * @return void
     */
    public function refGenerateForMe($isLocalRequest = false)
    {
        return $this->successResponse($this->authUser->refGenerateFromMeAndSave()->referal_url);
    }


        /**
     * Генерация реферальной ссылки на самого агента и сохранение ее в БД
     *
     * @param  mixed $request
     * @param  mixed $isLocalRequest
     *
     * @return void
     */
    public function test()
    {
        $test = new \App\Classes\YandexMoney\TestYandexPayout();
        return $test->run();
       // return $this->successResponse($this->authUser->refGenerateFromMeAndSave()->referal_url);
    }
}
