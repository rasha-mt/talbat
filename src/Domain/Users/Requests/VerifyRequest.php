<?php

namespace Domain\Users\Requests;

use App\Rules\ValidCode;
use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{

    public function rules()
    {
        return [
            'mobile'       => ['required', 'exists:users'],
            'code'         => ['required', 'digits:5', new ValidCode()],
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
