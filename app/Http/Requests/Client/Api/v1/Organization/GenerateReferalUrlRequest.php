<?php

namespace App\Http\Requests\Client\Api\v1\Organization;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReferalUrlRequest extends FormRequest
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
            'inn' => 'required|min:10|max:12',
            'name' => 'sometimes|string|min:1|max:190',
            'unique_id' => 'sometimes|integer|exists:users,unique_id',
            // 'unique_id' => 'required_with_all:user_id|integer|exists:users,unique_id',
            // 'user_id' => 'required_with_all:unique_id|integer|exists:users,id',
            'bid' => 'sometimes|integer|min:1',
        ];
    }
}
