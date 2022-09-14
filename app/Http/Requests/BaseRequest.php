<?php

namespace App\Http\Requests;

use Domain\Users\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function getUserByMobile()
    {
        $user = User::byMobile($this->mobile);

        return $user;
    }


}