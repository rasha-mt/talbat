<?php

namespace App\Exceptions;

use Throwable;

class AuthorizationExceptionHandler
{
    public function render(Throwable $exception)
    {
        $statusCode = 403;
        $message = 'forbidden';

        return response()->json([
            'code'    => $message,
            'message' => trans('validation.' . $message),
        ], $statusCode);
    }
}
