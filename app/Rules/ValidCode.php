<?php

namespace App\Rules;

use Domain\Users\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidCode implements Rule
{
    public function passes($attribute, $value)
    {
        $user =  User::byMobile(request()->mobile);

        return $user->isCodeValid($value);
    }

    public function message()
    {
        return trans('validation.incorrect_code');
    }
}
