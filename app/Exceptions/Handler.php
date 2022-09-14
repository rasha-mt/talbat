<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [

    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @var string[]
     */
    protected $handlers = [
        AuthorizationException::class    => AuthorizationExceptionHandler::class,
        AccessDeniedHttpException::class => AuthorizationExceptionHandler::class,
        ThrottleRequestsException::class => ThrottleRequestsExceptionHandler::class,
        HttpException::class             => HttpExceptionHandler::class,
        ModelNotFoundException::class    => ModelNotFoundHandler::class,
        ItemNotFoundException::class     => ModelNotFoundHandler::class,
    ];

    public function report(Throwable $exception)
    {
        $handler = Arr::get($this->handlers, get_class($exception));

        if ($handler && method_exists($handler, 'report')) {
            (new $handler())->report($exception);
        } else {
            parent::report($exception);
        }
    }

    public function render($request, Throwable $exception)
    {
        $handler = Arr::get($this->handlers, get_class($exception));

        if ($handler && method_exists($handler, 'render')) {
            return (new $handler())->render($exception);
        }

        return parent::render($request, $exception);
    }
}
