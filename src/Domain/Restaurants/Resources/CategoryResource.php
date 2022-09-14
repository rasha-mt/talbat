<?php

namespace Domain\Restaurants\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'restaurant' => $this->whenLoaded('restaurant', function () {
                return new RestaurantResource($this->restaurant);
            }),
            'meals'      => $this->whenLoaded('meals', function () {
                return MealResource::collection($this->meals);
            }),
        ];
    }
}