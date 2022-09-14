<?php

namespace Domain\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'longitude' => 'required|string',
            'latitude'  => 'required|string',
            'address'   => 'required|string',
        ];
    }

}