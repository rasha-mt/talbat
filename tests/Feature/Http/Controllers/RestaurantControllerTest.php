<?php

namespace Http\Controllers;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RestaurantControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @dataProvider RestaurantDataProvider
     */
    public function test_user_can_list_nearby_restaurants($lat, $lang)
    {
        $user = UserFactory::new()->withLocation()->create();
        $this->setUser($user)
            ->getJson('/api/v1/restaurants')->dump()
            ->assertSuccessful();

    }

    public function RestaurantDataProvider()
    {
        return [
            'near by'      => ['31.51302707512542', '34.43562404628763', 1],
            'near by more' => ['31.51957578372264', '34.43970100401849', 1],
            'far '         => ['31.701171133267696', '34.573724235672884', 0]
        ];
    }
}
