<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\SmsLog;

class TrackSmsLogAction
{
    public function __invoke( $status, $message, $mobile, $code)
    {
        return SmsLog::updateOrCreate(
            [
                'mobile' => $mobile,
                'code' => $code,
            ],
            [
                'status' => $status,
                'data' => $message,
            ]);
    }
}