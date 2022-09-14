<?php

namespace Domain\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnonymousLoginRequest extends FormRequest
{
    public function rules()
    {
        return [
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