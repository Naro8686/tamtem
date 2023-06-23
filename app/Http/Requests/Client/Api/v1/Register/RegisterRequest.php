<?php

namespace App\Http\Requests\Client\Api\v1\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:190',
            'email' => 'required|string|email|max:190|unique:users',
            'password' => 'required|string|min:6|max:190',
            'phone'    => 'sometimes|regex:/(^(\d+)$)/u|min:10|max:10',
            'license_agreement' => 'accepted',
            'agent_id' => 'sometimes|exists:users,unique_id',
        ];
    }
}
