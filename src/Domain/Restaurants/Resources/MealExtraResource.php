<?php

namespace Domain\Restaurants\Resources;

use App\Http\Resources\BaseResource;

class MealExtraResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'options' => $this->options(),
        ];
    }

    private function options(): array
    {
        return collect($this->options)->map(function ($value, $key) {
            return [
                'key'   => $key,
                'value' => $value,
            ];
        })->values()->toArray();
    }
}