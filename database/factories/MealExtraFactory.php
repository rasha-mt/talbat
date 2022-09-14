<?php

namespace Database\Factories;

use Domain\Restaurants\Models\MealExtra;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealExtraFactory extends Factory
{
    protected $model = MealExtra::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'   => $this->faker->title(),
            'options' => []
        ];
    }
}
