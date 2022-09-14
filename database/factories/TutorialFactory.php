<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tutorial>
 */
class TutorialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'   => $this->faker->title(),
            'text'    => $this->faker->text(),
            'image'   => $this->faker->title(),
            'enabled' => true,
            'order'   => $this->faker->numberBetween(1, 10),
        ];
    }
}
