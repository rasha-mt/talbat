<?php

namespace App\Exceptions;

use Modules\Notifications\Notifications\Operation\ExceededAllowableLimitNotification;
use Modules\Notifications\Support\Slack;
use Throwable;

class ThrottleRequestsExceptionHandler
{
    public function render(Throwable $exception)
    {
        $statusCode = $exception->getStatusCode();
        $message = 'too_many_attempts';

        return response()->json([
            'code'    => $message,
            'message' => trans('validation.' . $message),
        ], $statusCode);
    }
}
