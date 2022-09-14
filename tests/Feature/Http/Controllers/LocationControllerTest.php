<?php

namespace Http\Controllers;

use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_list_his_locations()
    {
        $user = UserFactory::new()->withLocation(2)->create();
        $this->setUser($user)
            ->getJson('/api/v1/users/locations')
            ->assertSuccessful()
            ->assertJsonCount(2, 'data.*')
            ->assertJsonStructure([
                'data' => [
                    ['id',
                        'latitude',
                        'longitude',
                        'address',
                    ]
                ]
            ]);
    }

    public function test_can_user_add_new_location()
    {
        $user = UserFactory::new()->create();
        $this->setUser($user)
            ->postJson('/api/v1/users/locations', [
                'longitude' => 'x222222',
                'latitude'  => 'y2020202',
                'address'   => 'xx'
            ])
            ->assertSuccessful();

        $location = $user->locations()->first();
        $this->assertEquals('x222222', $location->longitude);
        $this->assertEquals('y2020202', $location->latitude);
        $this->assertEquals('xx', $location->address);
    }

    public function test_can_user_edit_his_location()
    {
        $user = UserFactory::new()->withLocation()->create();
        $this->setUser($user)
            ->putJson('/api/v1/users/locations/1', [
                'longitude' => 'ww1020',
                'latitude'  => 'g1122',
                'address'   => 'xxx'
            ])
            ->assertSuccessful();
        $location = $user->locations()->first();
        $this->assertEquals('ww1020', $location->longitude);
        $this->assertEquals('g1122', $location->latitude);
    }

    public function test_can_user_delete_his_location()
    {
        $user = UserFactory::new()->withLocation()->create();
        $this->setUser($user)
            ->deleteJson('/api/v1/users/locations/1')
            ->assertSuccessful();

        $this->assertEquals(0, $user->locations()->count());
    }

}
