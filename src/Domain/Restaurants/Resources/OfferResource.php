<?php

namespace Domain\Restaurants\Resources;

use App\Http\Resources\BaseResource;

class OfferResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'discount'      => $this->discount,
            'discount_type' => $this->discount_type,
            'meal'          => $this->whenLoaded('meal', function () {
                return new MealResource($this->meal);
            })
        ];
    }
}