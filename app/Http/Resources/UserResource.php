<?php

namespace App\Http\Resources;

class UserResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'mobile'      => $this->mobile,
            'is_verified' => $this->is_verified,
            'created_at'  => $this->created_at,
        ];
    }


}