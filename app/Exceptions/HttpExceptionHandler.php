<?php

namespace App\Exceptions;

use Throwable;

class HttpExceptionHandler
{
    public function render(Throwable $exception)
    {
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage();
        $translated_message = null;
        $translator = trans();

        if ($this->isInMaintanceMode($statusCode)) {
            return response()->json([
                'code'    => 'app_in_maintenance_mode',
                'message' => 'التطبيق الان في وضع الصيانة, يرجى المحاولة في وقت لاحق.',
            ], $statusCode);
        }

        if ($translator->has('validation.' . $message)) {
            $translated_message = trans('validation.' . $message);
        }

        return response()->json([
            'code'    => $message,
            'message' => $translated_message ?? $message,
        ], $statusCode);
    }

    /**
     * @param $statusCode
     * @return bool
     */
    public function isInMaintanceMode($statusCode): bool
    {
        return $statusCode == 503;
    }
}
