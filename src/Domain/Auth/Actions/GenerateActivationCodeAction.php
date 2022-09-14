<?php

namespace Domain\Auth\Actions;

use Carbon\Carbon;
use App\Models\Setting;

class GenerateActivationCodeAction
{
    public function __invoke($auth)
    {
        $verification_code = self::generateActivationCode();

        $validity = self::getActivationCodeValidity();

        $auth->update([
            'expired_at'        => Carbon::now()->addHours($validity),
            'verification_code' => $verification_code,
            'used_times'        => $auth->used_times + 1,
        ]);

        return $verification_code;
    }

    public static function generateActivationCode()
    {
        return rand(10000, 99999);
    }

    public static function getActivationCodeValidity()
    {
        return Setting::RESEND_MAX_WITHIN;
    }
}
