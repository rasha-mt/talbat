<?php

namespace Domain\Restaurants\Builders;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class RestaurantBuilder extends Builder
{
    public function nearBy($longitude, $latitude): RestaurantBuilder
    {
        $near_by_distance = Setting::value(Setting::NEARBY_RESTAURANT_DISTANCE);

        return $this->select(DB::raw("*, ( 3959 * acos( cos( radians('$latitude') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians( latitude ) ) ) ) AS distance"))
            ->havingRaw("distance < '$near_by_distance'")
            ->orderBy('distance');
    }

    public function active(): RestaurantBuilder
    {
        return $this->where('is_active', true);
    }

}