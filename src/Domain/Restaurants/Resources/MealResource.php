<?php

namespace Domain\Restaurants\Resources;

use App\Http\Resources\BaseResource;

class MealResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'image'         => $this->image,
            'regular_price' => $this->regular_price,
            'extras'        => $this->whenLoaded('extras', value: function () {
                return MealExtraResource::collection($this->extras);
            }),
            'offer'         => $this->whenLoaded('offer', function () {
                return new OfferResource($this->offer);
            })
        ];
    }
}