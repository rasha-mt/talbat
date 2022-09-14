<?php

namespace Database\Factories;

use Domain\Restaurants\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;


class OfferFactory extends Factory
{
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'         => $this->faker->title(),
            'meal_id'       => MealFactory::new(),
            'discount'      => 10,
            'discount_type' => 'amount'
        ];
    }
}
