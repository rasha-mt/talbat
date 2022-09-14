<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($message = '', $code = 200, $data = []): JsonResponse
    {
        $message = empty($message) ? __('validation.success') : $message;

        $message = [
            'message' => $message,
        ];

        $data = array_merge($message, $data);

        return response()->json([
            'data' => $data,
        ], $code);
    }

    public function forbidden($code = 403): JsonResponse
    {
        return response()->json([], $code);
    }
}
