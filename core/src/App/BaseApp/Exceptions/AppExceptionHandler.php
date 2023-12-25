<?php

namespace App\BaseApp\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\LazyLoadingViolationException;
use App\BaseApp\Exceptions\Handlers\ValidationExceptionHandler;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\BaseApp\Exceptions\Handlers\NotFoundRouteExceptionHandler;
use App\BaseApp\Exceptions\Handlers\LazyLoadingViolationExceptionHandler;

class AppExceptionHandler extends ExceptionHandler
{
    protected $dontReport = [
    ];
    protected $dontFlash = [
    ];

    public function render($request, Throwable $e)
    {
        return match (get_class($e)) {
            RouteNotFoundException::class => (new NotFoundRouteExceptionHandler())($request, $e),
            LazyLoadingViolationException::class => (new LazyLoadingViolationExceptionHandler())($e),
            ValidationException::class => (new ValidationExceptionHandler())($request, $e),
            default => parent::render($request, $e),
        };
    }
}
