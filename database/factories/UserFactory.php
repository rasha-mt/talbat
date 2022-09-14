<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'           => fake()->name(),
            'remember_token' => Str::random(10),
        ];
    }

    public function withDevice($count = 1)
    {
        return $this->has(DeviceFactory::new()->count($count));
    }

    public function withLocation($count = 1)
    {
        return $this->has(LocationFactory::new()->count($count));
    }

}
