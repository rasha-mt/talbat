<?php

namespace Domain\Auth\Models\Concerns;

use App\Models\Setting;
use Domain\Auth\Models\SmsLog;
use App\Jobs\SendActivationCode;
use Domain\Auth\Actions\GenerateActivationCodeAction;

trait MobileActivation
{
    public static function byMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }

    public function send()
    {
        app(GenerateActivationCodeAction::class)($this);
        if (!config('delivery.sms_status')) {
            return;
        }
        $this->smsUsingProvider();
    }

    public function verify($device)
    {
        $this->update(['is_verified' => true]);

        return $this->generateUserToken($device);
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    public function isCodeValid($code)
    {
        return !config('delivery.sms_status')
            || $this->verification_code == $code;
    }

    public function canResendCode()
    {
        return !$this->isMaxResendReach() || $this->isExpirationTimePassed();
    }

    public function isMaxResendReach(): bool
    {
        return ($this->used_times + $this->sms_log_count) >= Setting::RESEND_MAX_LIMIT;
    }

    public function isExpirationTimePassed(): bool
    {
        return $this->expired_at && $this->expired_at < now();
    }

    public function generateUserToken($device)
    {
        return $this->createToken($device->generateTokenName())->plainTextToken;
    }

    public function smsText($withEncode = false)
    {
        return trans('validation.sms_verification_code') . ' ' . $this->verification_code;
    }

    public function getSmsLogCountAttribute()
    {
        $mobile = $this->getVerificationMobile();

        return SmsLog::where('mobile', $mobile)
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count();
    }

    /**
     * @param int $verification_code
     *
     */

    protected function smsUsingProvider(): void
    {
        SendActivationCode::dispatch($this);
    }

    public function getVerificationMobile()
    {
        return $this->mobile;
    }
}
