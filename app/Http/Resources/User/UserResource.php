<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property int unique_id
 * @property int status
 * @property int role
 * @property string phone
 * @property string photo
 * @property int privilege_id
 * @property int points
 * @property double ballance
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $privilege = $this->privilege;
        return [
            'id'=> $this->id, 
            'name'=> $this->name, 
            'email'=> $this->email,
            'unique_id'=> $this->unique_id,
            'status'=> $this->status,
            'role'=> $this->role,
            'phone'=> $this->phone,
            'photo'=> $this->photo,
            'privilege'=> ['id' => $privilege->id, 'name' =>  $privilege->name, 'procent' =>  $privilege->procent, 'duration_months' =>  $privilege->duration_months],
            'points'=> $this->points,
            'points_from_agents'=> $this->points_from_agents,
            'ballance'=> $this->ballance,
            'referal_url'=> $this->referal_url,
        ];
    }
}
