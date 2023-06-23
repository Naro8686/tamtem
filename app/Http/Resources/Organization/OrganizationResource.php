<?php

namespace App\Http\Resources\Organization;

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
class OrganizationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id, 
            'user_id'=> $this->user_id, 
            'inn'=> $this->inn, 
            'name'=> $this->name,
            'status'=> $this->status,
            'referal_url'=> $this->referal_url,
            'parameters_url'=> $this->parameters_url,
            //'category_name'=>  ($this->category_name !== null) ? implode(". ", json_decode($this->category_name)) : $this->category_name,
            'category_name'=>  ($this->category_name !== null) ? explode(",", $this->category_name) : $this->category_name,
            'points_buy_bid'=> $this->points_buy_bid,
            'points_set_winner'=> $this->points_set_winner,
            'points_response'=> $this->points_response,
            'response_ballance'=> $this->response_ballance,
            'activated_at'=> $this->activated_at,
            'before_to_at'=> $this->before_to_at,
        ];
    }
}