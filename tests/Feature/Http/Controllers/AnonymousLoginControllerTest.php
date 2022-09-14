<?php

namespace Http\Controllers;

use Domain\Users\Models\User;
use Database\Factories\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AnonymousLoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login()
    {
        $this->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => 1,
                ]
            ])
            ->assertJsonStructure([
                'meta' => [
                    'token',
                ]
            ]);
    }

    public function test_it_create_devices_for_use()
    {
        $this->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful();

        $user = User::find(1);
        $this->assertEquals(1, $user->tokens()->count());

        $token = $user->tokens()->first();
        $this->assertEquals('ios-1111', $token->name);
        $this->assertEquals(1, $user->devices()->count());

        $device = $user->devices()->first();
        $this->assertEquals('1111', $device->device_id);
        $this->assertEquals('ios', $device->device_type);
        $this->assertEquals('xxxxxxxxxx', $device->device_token);
        $this->assertNotNull($device->device_info);
    }

    public function test_when_user_is_anonymous_it_return_same_user()
    {
        $user = UserFactory::new()->create();
        $user->devices()->create([
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ]);

        $this->setAnonymous($user)->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson([
                'data' => ['id' => 1]
            ]);
    }

    public function test_when_user_is_known_it_return_new_user()
    {
        $user = UserFactory::new()->create();

        $this->setAnonymous($user)->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson([
                'data' => ['id' => 2]
            ]);
    }


    public function test_double_request_avoidance()
    {
        $this->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson([
                'data' => ['id' => 1]
            ]);
        $this->postJson('api/v1/users/anonymous-login', [
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson([
                'data' => ['id' => 1]
            ]);
    }
}
