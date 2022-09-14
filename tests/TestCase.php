<?php

namespace Tests;

use App\Models\Setting;
use Laravel\Sanctum\Sanctum;
use Domain\Users\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::fake(Setting::RESEND_MAX_LIMIT, 3);
        Setting::fake(Setting::RESEND_MAX_WITHIN, 24);
    }

    public function setAnonymous(User $user = null): self
    {
        Sanctum::actingAs($user ?? UserFactory::new()->unkown()->create(), [], 'sanctum');

        return $this;
    }

    public function setUser($user = null): self
    {
        Sanctum::actingAs($user ?? UserFactory::new()->create());

        return $this;
    }

}
