<?php

namespace App\Providers;

use App\Validator\CustomValidator;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Request::is('nova*')) {
            Validator::resolver(function ($translator, $data, $rules, $messages) {
                return new CustomValidator($translator, $data, $rules);
            });
        }

        TestResponse::macro('assertDataStructure', function ($structure) {
            $this->assertJsonStructure([
                'data' => $structure,
            ]);

            return $this;
        });

        TestResponse::macro('assertSuccessResponse', function ($message = null) {
            $this->assertSuccessful()
                ->assertJson([
                    'data' => [
                        'message' => $message ?? trans('validation.success'),
                    ],
                ]);

            return $this;
        });

        TestResponse::macro('assertFailedResponse', function ($message, $code = null) {
            $translated_message = null;
            $translator = trans();

            if ($translator->has('validation.' . $message) || $message == 'forbidden' || $message == 'too_many_attempts') {
                $translated_message = trans('validation.' . $message);
            }

            $this->assertJson([
                'code'    => $message,
                'message' => $translated_message ?? $message,
            ]);

            if ($code) {
                $this->assertStatus($code);
            }

            return $this;
        });

    }
}
