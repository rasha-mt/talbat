<?php

namespace Domain\Users\Requests;

use Domain\Users\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'user_id'      => 'nullable|integer|exists:users',
            'mobile'       => [
                'required',
                Rule::phone()->detect()->country('PS')
            ],
            'device_id'    => [
                'required',
            ],
            'device_type'  => [
                'in:android,ios',
            ],
            'device_token' => [
                'required',
            ],
            'device_info'  => [
                'nullable',
            ],
        ];
    }


}
