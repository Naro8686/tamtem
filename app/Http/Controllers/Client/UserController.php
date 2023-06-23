<?php

namespace App\Http\Controllers\Client;


use App\Http\Resources\User\UserResource;
use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Client\Api\v1\User\UserStoreRequest;
use App\Http\Requests\Client\Api\v1\User\UserUpdateRequest;
use App\Http\Requests\Client\Api\v1\User\UserImageDeleteRequest;
use Auth;
use App\Traits\ApiControllerTrait;
use App\Traits\ImageTrait;

class UserController extends Controller
{

    use ApiControllerTrait;
    use ImageTrait;

    /**
    * @var UserService
    */
    private $userService;

    /**
    * @var UserService
    */
    private $authUser;

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authUser = Auth::guard('api')->user();
    }

    public function index(Request $request)
    {
       return $this->userService->index($request);
    }
   
   /**
    * @param int $id
    * @return UserResource
    * @throws Exception
    */
    public function get(int $id)
    {
        // если юзер просит свои данные или админ
        if($this->authUser->id === $id or $this->authUser->isAdmin()){
            $user = $this->userService->get($id);

            if($user instanceof User){
                return $this->successResponse(new UserResource($user));
            }
            else{
                return $this->errorResponse($user);
            }
        }
        else{
            return $this->errorResponse();
        }
    }

    /**
    * @param UserStoreRequest $request
    * @return UserResource
    * @throws Exception
    */
    public function create(UserStoreRequest $request)
    { 
        /** @var User $user */
        // $curUser = Auth::guard('api')->user();
        $data = $request->all();

        $image = $data['photo'] ?? null;

        if($image) {
            unset($data['photo']);
        }

        $user = $this->userService->create($data);

        if($user instanceof User){

            if($image){
                if($path = $this->imageSave($image , 'users/' . $user->id . '/lk/images')){
                    $user->photo = $path;
                    $user->save();
                }
            }

            return $this->successResponse(new UserResource($user));
        }
        else{
            return $this->errorResponse($user);
        }
    }


    /**
    * @param int $id
    * @param UserUpdateRequest $request
    * @return UserResource
    * @throws Exception
    */
    public function update(int $id, UserUpdateRequest $request)
    {
        // если юзер сам или админ
        if($this->authUser->id === $id or $this->authUser->isAdmin()){

            $data = $request->all();

            // если загружаем фото.
            if(array_key_exists('photo', $data)) {
                
                // найдем, кому принадлежит фото и что оно реально этого юзера
                $user = $this->userService->get($id);
                if($user instanceof User){
                    // удалим фото старое
                    $this->imageDelete($user->photo);
                    // загрузим новое фото
                    $data['photo'] = $this->imageSave($data['photo'] , 'users/' . $user->id . '/lk/images');
                }
            }
    
            $user = $this->userService->update($id, $data);
    
            if($user instanceof User){
                return $this->successResponse(new UserResource($user));
            }
            else{
                return $this->errorResponse($user);
            }
        }
        else{
            return $this->errorResponse();
        }
    
    }

    /**
    * @param int $id
    * @return JsonResponse
    * @throws Exception
    */
    public function delete(int $id)
    {
        
        $user =  $this->userService->delete($id);

        if($user instanceof User){
            return $this->successResponse(['id' => $user->id]);
        }
        else{
            return $this->errorResponse($user);
        }
    }

    /**
    * @param int $id
    * @return JsonResponse
    * @throws Exception
    */
    public function restore(int $id)
    {
        $user =  $this->userService->restore($id);

        if($user instanceof User){
            return $this->successResponse(['id' => $user->id]);
        }
        else{
            return $this->errorResponse($user);
        }
    }

    
    public function deleteImage(UserImageDeleteRequest $request)
    {
        try{

            $path['photo'] = $request['photo'] ;

            $userId = null;

            // если юзер удаляет свое фото
            if($this->authUser->photo === $path['photo']){
                $userId = $this->authUser->id;
            }
            elseif($this->authUser->isAdmin()){ // юзер - это админ и имеет право удалять чужое
                // найдем, кому принадлежит фото
                if($user = $this->userService->getRowValue('photo',  $path['photo'])) {
                    $userId =  $user->id;
                }
            }
            else{
                return $this->errorResponse('Не возможно удалить фото: ' .  $path['photo']);
            }

            if($userId){
                // удалим фото старое
                $this->imageDelete($path['photo']);
            
                // обновим поле
                $user = $this->userService->update($userId, array('photo' => null));

                if($user instanceof User){
                    return $this->successResponse(new UserResource($user));
                }
                else{
                    return $this->errorResponse($user);
                }
            }
            else{
                return $this->errorResponse();
            }
      
        }
        catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
  
    }
}
