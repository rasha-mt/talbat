<?php

namespace Database\Factories;

use Domain\Restaurants\Models\Meal;
use Domain\Restaurants\Models\MealExtra;
use Illuminate\Database\Eloquent\Factories\Factory;


class MealFactory extends Factory
{
    protected $model = Meal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->title(),
            'description'   => $this->faker->text(),
            'image'         => $this->faker->title(),
            'regular_price' => 20,
        ];
    }

    public function withExtras($count = 1)
    {
        return $this->has(MealExtraFactory::new()->count($count));
    }

    public function withOffers()
    {
        return $this->has(OfferFactory::new());
    }
}
