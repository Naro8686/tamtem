<?php

namespace App\Rules;

use App\Models\Privileges;
use Illuminate\Contracts\Validation\Rule;

class PrivilegesRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            foreach ($value as $val) {
                if (!Privileges::find($val))
                    return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Нет такой категории, вы посылаете ошибочные данные';
    }
}
