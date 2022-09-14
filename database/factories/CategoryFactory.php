<?php

namespace Database\Factories;

use Domain\Restaurants\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->title(),
            'is_active'     => true,
            'restaurant_id' => RestaurantFactory::new()
        ];
    }

    public function withMeals($count = 1)
    {
        return $this->has(MealFactory::new()->count($count));
    }
}
