<?php

namespace App\Http\Requests\Client\Api\v1\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $max_size = (int)ini_get('upload_max_filesize') * 1000;

        return [
            'name' => 'sometimes|string|max:190',
            'email' => 'sometimes|string|email|max:190|unique:users',
            'password' => 'sometimes|string|min:6|max:190|confirmed',
            'status' => 'sometimes|integer|in:' . implode(",", \App\Models\User::STATUSES),
            'role'   => 'sometimes|integer|in:' . implode(",", \App\Models\User::ROLES ),
            'phone' => 'sometimes|regex:/(^(\d+)$)/u|min:10|max:10',
            'photo' => 'sometimes|image|max:' . $max_size, //'sometimes|nullable|mimes:jpeg,bmp,png|max:' . $max_size,
            'privilege_id' => 'sometimes|exists:privileges,id',
            'points' => 'sometimes|integer|min:0|max:2140000000',
            'ballance' => 'sometimes|numeric|min:0|max:99999999|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }
}
