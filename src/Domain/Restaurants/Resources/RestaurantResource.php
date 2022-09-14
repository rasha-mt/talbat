<?php

namespace Domain\Restaurants\Resources;

use App\Http\Resources\BaseResource;

class RestaurantResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'logo'              => $this->logo,
            'image'             => $this->image,
            'shipping_price'    => $this->shipping_price,
            'shipping_duration' => $this->shipping_duration,
            'rating'            => $this->avg_rating
        ];
    }
}