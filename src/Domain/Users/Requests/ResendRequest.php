<?php

namespace Domain\Users\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ResendRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'mobile' => 'exists:users,mobile'
        ];
    }

    public function messages()
    {
        return [
            'mobile.exists' => trans('validation.mobile_exists'),
        ];
    }
}
