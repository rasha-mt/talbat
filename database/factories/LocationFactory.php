<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Domain\Users\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'latitude'  => '18.5789',
            'longitude' => '73.7707',
            'address'   => Str::random(10),
        ];
    }

}