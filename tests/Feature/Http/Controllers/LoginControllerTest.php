<?php

namespace Http\Controllers;

use Domain\Users\Models\User;
use Illuminate\Support\Carbon;
use App\Jobs\SendActivationCode;
use Database\Factories\DeviceFactory;
use Database\Factories\UserFactory;
use Domain\Auth\Models\Device;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login_and_linked_with_device()
    {
        $auth = UserFactory::new()->create([
            'mobile' => '+970593456789',
        ]);

        $this->postJson("api/v1/users/login", [
            'mobile'       => '+970593456789',
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'xxxxxxxxxx',
            'device_info'  => 'data',
        ])->assertSuccessful()
            ->assertJson(
                ['data' =>
                     [
                         'id'     => 1,
                         'mobile' => '970593456789',
                     ]
                ]);

        $this->assertEquals(1, $auth->devices()->count());
        $device = $auth->devices()->first();
        $this->assertEquals('1111', $device->device_id);
        $this->assertEquals('ios', $device->device_type);
        $this->assertEquals('xxxxxxxxxx', $device->device_token);
        $this->assertNotNull($device->device_info);
    }

    public function test_user_can_logout_from_all_devices()
    {
        $auth = UserFactory::new()->create(['is_verified' => true]);
        $auth->registerDevice([
            'device_id'    => '1',
            'device_type'  => 'android',
            'device_token' => '123456',
            'device_info'  => null,
        ]);

        $auth->createToken('device-1');
        $auth->createToken('device-2');
        $token = $auth->createToken('android-1')->plainTextToken;

        $this->assertEquals(3, $auth->tokens()->count());

        $this->postJson("/api/v1/users/logout", [], [
            'Authorization' => "Bearer $token",
        ])->assertSuccessResponse();

        $this->assertEquals(2, $auth->tokens()->count());

        $this->postJson("/api/v1/users/logout", [
            'all' => true,
        ], [
            'Authorization' => "Bearer $token",
        ])->assertSuccessResponse();

        $this->assertEquals(0, $auth->tokens()->count());

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id'   => $auth->id,
            'tokenable_type' => User::class,
        ]);

        $this->assertFalse($auth->is_verified);
    }


    public function test_user_can_logout_from_one_devices()
    {
        $auth = UserFactory::new()->create();

        $auth->registerDevice([
            'device_id'    => 'MMB29K',
            'device_type'  => 'android',
            'device_token' => '123456',
            'device_info'  => null,
            'version'      => '1',
        ]);

        $auth->registerDevice([
            'device_id'    => 'R16NW',
            'device_type'  => 'android',
            'device_token' => '12345678',
            'device_info'  => null,
            'version'      => '1',

        ]);

        $auth->createToken('device-MMB29K');
        $auth->createToken('device-R16NW');
        $token = $auth->createToken('device-R16NW')->plainTextToken;

        $token2 = $auth->createToken('device-R16NW')->plainTextToken;

        $this->postJson("/api/v1/users/logout", [], [
            'Authorization' => "Bearer $token2",
        ])->assertSuccessResponse();
    }


    public function test_it_create_device_if_not_exists()
    {
        $user = UserFactory::new()->create();

        $this->setUser($user)
            ->putJson('api/v1/users/update-device-token', [], [
                'device_token' => 'fake-token',
                'device_type'  => 'android',
                'device_id'    => '191',
            ])
            ->assertSuccessful();
        $this->assertTrue($user->devices()->first()->exists());

        $this->assertEquals('fake-token', $user->devices()->first()->device_token);
    }

    public function test_it_update_device_token()
    {
        $user = UserFactory::new()->create();
        DeviceFactory::new()->create([
            'authable_id'   => $user->id,
            'authable_type' => User::class,
            'device_type'   => 'android',
            'device_id'     => '191',
        ]);
        $this->setUser($user)
            ->withHeaders(['app-version' => 140])
            ->putJson('api/v1/users/update-device-token', [], [
                'device_token' => 'fake-token',
                'device_type'  => 'android',
                'device_id'    => '191',
            ])
            ->assertSuccessful();
        $this->assertEquals('fake-token', $user->devices()->first()->device_token);
    }

    public function test_it_do_not_throw_an_exception_when_update_device_token_if_it_is_exists()
    {
        $user = UserFactory::new()->create();
        DeviceFactory::new()->create([
            'authable_id'   => $user->id,
            'authable_type' => User::class,
            'device_type'   => 'android',
            'device_id'     => '191',
        ]);

        $this->setUser($user)
            ->putJson('api/v1/users/update-device-token', [
                'device_token' => 'old token',
                'device_type'  => 'android',
                'device_id'    => '1912',
            ])
            ->assertSuccessful();
    }

    public function test_anonymous_user_verification()
    {
        //Event::fake();
        $user = UserFactory::new()->create([
            'mobile'            => '+970593456789',
            'verification_code' => '88888',
        ]);

        $this->setAnonymous($user)->postJson('/api/v1/users/verify', [
            'mobile'       => '+970593456789',
            'code'         => '88888',
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'zxxxxxxxxx',
        ])->assertSuccessful()
            ->assertJson(
                ['data' =>
                     [
                         'id'          => 1,
                         'is_verified' => true,
                     ]
                ]);

    }

    public function test_specialists_can_verify_their_account()
    {
        $user = UserFactory::new()->create([
            'mobile'            => '+970553456789',
            'verification_code' => '88888',
        ]);

        $this->setUser($user)->postJson('/api/v1/users/verify', [
            'mobile'       => '+970553456789',
            'code'         => '88888',
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'zxxxxxxxxx',
        ])->assertSuccessful()
            ->assertJsonStructure([
                'meta' => ['token']
            ]);

        $this->assertEquals(1, $user->tokens()->count());
        $this->assertTrue($user->fresh()->is_verified);
    }

    public function test_specialists_cant_verify_their_account_using_invalid_code()
    {
        $user = UserFactory::new()->create([
            'mobile'            => '+970553456789',
            'verification_code' => '1234',
            'expired_at'        => Carbon::now()->addDay(),
            'is_verified'       => false,
        ]);

        $this->setUser($user)->postJson('/api/v1/users/verify', [
            'mobile'       => '+970553456789',
            'code'         => '432',
            'device_id'    => '1111',
            'device_type'  => 'ios',
            'device_token' => 'zxxxxxxxxx',
        ])->assertJsonValidationErrors(['code']);

        $this->assertEquals(0, $user->devices()->count());
    }

    public function test_user_can_resend_code_three_times_within_24_hours()
    {
        $user = UserFactory::new()->create([
            'is_verified' => false,
            'mobile'=> '+97250000111'
        ]);

        Carbon::setTestNow();

        $user->send();
        $user->send();
        $user->send();

        $this->setUser($user)->postJson('/api/v1/users/resend',[
            'mobile'       => '+97250000111'
        ])
            ->assertForbidden()
            ->assertFailedResponse('cant_generate_code');

        Carbon::setTestNow(now()->addHours(22));
        $this->postJson('/api/v1/users/resend')
            ->assertForbidden()
            ->assertFailedResponse('cant_generate_code');

        Carbon::setTestNow(now()->addHours(24));
        $this->postJson('/api/v1/users/resend')
            ->assertSuccessResponse(trans('validation.sms_in_sending'));
    }

    public function test_resend_code_to_user()
    {
        UserFactory::new()->create([
            'is_verified' => false,
            'mobile'      => '+97259944661'
        ]);

        $this->postJson('/api/v1/users/resend', [
            'mobile' => '+97259944661'
        ])
            ->assertSuccessResponse(trans('validation.sms_in_sending'));
    }

}
