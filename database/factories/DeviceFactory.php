<?php

/** @var Factory $factory */

namespace Database\Factories;

use Domain\Auth\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'device_id'    => Str::random(10),
            'device_type'  => $this->faker->randomElement(['android', 'ios']),
            'version'      => 1,
            'device_token' => Str::random(10)
        ];
    }
}
