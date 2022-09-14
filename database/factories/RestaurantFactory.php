<?php

/** @var Factory $factory */

namespace Database\Factories;

use Domain\Auth\Models\Device;
use Domain\Restaurants\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name'        => $this->faker->name(),
            'description' => $this->faker->text(),
            'latitude'    => '31.51500271153864',
            'longitude'   => '34.439143104539525',
            'logo'        => $this->faker->text(),
            'image'        => $this->faker->text(),
        ];
    }

    public function withCategory($count = 1)
    {
        return $this->has(CategoryFactory::new()->count($count));
    }
}
