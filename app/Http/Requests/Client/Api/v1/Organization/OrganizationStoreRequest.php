<?php

namespace App\Http\Requests\Client\Api\v1\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class OrganizationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'user_id' => 'required|integer|exists:users,id',
            'inn' => 'required|min:10|max:12',
            'name' => 'required|string|min:1|max:190',
            'status' => 'sometimes|integer|in:' . implode(",", \App\Models\Organization::STATUSES),
            'referal_url' => 'required|unique:organizations,referal_url',
            'category_name' => 'sometimes|json',
            'points_buy_bid' => 'sometimes|integer|min:0|max:2140000000',
            'points_set_winner' => 'sometimes|integer|min:0|max:2140000000',
            'points_response' => 'sometimes|integer|min:0|max:2140000000',
            'response_ballance' => 'sometimes|numeric|min:0|max:99999999|regex:/^\d+(\.\d{1,2})?$/',
            'activated_at' => 'sometimes|date_format:Y-m-d|after_or_equal:' . Carbon::now(),
            'before_to_at' => 'sometimes|date_format:Y-m-d|after_or_equal:activated_at',
        ];
    }
}
