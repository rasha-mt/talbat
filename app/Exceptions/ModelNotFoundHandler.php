<?php

namespace App\Exceptions;

class ModelNotFoundHandler
{
    public function render($notFoundException)
    {
        return response()->json([
            'code'    => 'not_found',
            'message' => $notFoundException->getMessage(),
        ], 404);
    }
}
