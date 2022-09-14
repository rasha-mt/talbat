<?php

namespace Domain\Users\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'latitude'=> $this->latitude,
            'longitude'=> $this->longitude,
            'address'=> $this->address,
        ];

    }

}