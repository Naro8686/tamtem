<?php

namespace App\Services\User;

use App\Models\User as Model;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Hash;

class UserService
{

    /**
     * Проверка, сучествует ли колонка со значением
    * @param Request $request
    * @return Collection
    */
    public function isRowValueExists($row, $val) {
        return Model::where($row, $val)->exists();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getRowValue($row, $val)
    {
        /** @var Model $model */
        $model = Model::where($row, '=', $val)->first();
        return $model;
    }

       /**
     * @param int $id
     * @return Model
     */
    public function setUserRegistered($token)
    {
        if($user = $this->getRowValue('register_confirm_token', $token)) {

            $user->status = Model::USER_STATUS_APPROVE;
            $user->register_confirm_token = null;
            
            $user->save();
            return $user;
        }

        return null;
    }
    
    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        $query = Model::query();

        // $query->when(true === $request->has('budget_from'), function (Builder $query) use ($request) {
        //     $query->where('budget_from', '=', $request->input('budget_from'));
        // });
    
        // $query->when(true === $request->has('budget_to'), function (Builder $query) use ($request) {
        //     $query->where('budget_to', '=', $request->input('budget_to'));
        // });
    
        // $query->when(true === $request->has('procent'), function (Builder $query) use ($request) {
        //     $query->where('procent', '=', $request->input('procent'));
        // });

        
        return $query->paginate(15);

        // return $query->select([ 'id',  
        //                         'created_at', 
        //                         'updated_at'])->paginate(15);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function get(int $id)
    {
         
        /** @var Model $model */
        $model = Model::where('id', '=', $id);

        $model = $model->first();

        if (null === $model) {
            $model = "Запись {$id} не найдена или не доступна для вас";
        }

        return $model;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getSoftDeleted(int $id)
    {
         
        /** @var Model $model */
        $model = Model::withTrashed()->where('id', $id)->first();

        if (null === $model) {
            $model = "Запись {$id} не найдена среди удаленных или не доступна для вас";
        }

        return $model;
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    { 
        $data ['password']  = Hash::make($data['password']);
        $data ['unique_id'] = Model::generateUniqueUserIdNumber();
        $data ['referal_url'] = Model::refGenerateFromMeFromUniqueId($data ['unique_id']);
        $data ['from_agent'] = $data ['from_agent'];
        $data ['privilege_id'] = $data ['privilege_id'] ?? 1;  

        return Model::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data)
    {
        $model = $this->get($id);

        if($model instanceof Model){

            if( isset($data['password'])) $data['password'] = Hash::make($data['password']);

            $model->update($data);
        }

        return $model;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id)
    {
        $model = $this->get($id);

        if($model instanceof Model){
            $model->delete();
        }
        return $model;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function restore(int $id)
    {
        $model = $this->getSoftDeleted($id);

        if($model instanceof Model){
            $model->restore();
        }
        return $model;
    }

    /**
     * Генерирует реферальную ссылку
     *
     * @param  integer $id
     *
     * @return string
     */
    public function refGenerateFromUserId($id)
    {
        $model = $this->get($id);

        if($model instanceof Model){

            $unique_id = $model->unique_id;

            $parametersToRefUrl = [
                'agent_id' => base64_encode( $model->unique_id), 
            ];

            $refUrl =  asset('/') . "?" . http_build_query($parametersToRefUrl);

            return $refUrl;
          
        }

        return null;
    }

        /**
     * Генерирует реферальную ссылку
     *
     * @param  integer $id
     *
     * @return string
     */
    public function refGenerateFromMeAndSaveFromUserId($id)
    {
        $model = $this->get($id);

        if($model instanceof Model){

            $unique_id = $model->unique_id;

            $parametersToRefUrl = [
                'agent_id' => base64_encode( $model->unique_id), 
            ];

            $refUrl =  asset('/') . "?" . http_build_query($parametersToRefUrl);

            $model->referal_url = $refUrl;
            $model->save();
         
        }

        return $model;
    }
}
