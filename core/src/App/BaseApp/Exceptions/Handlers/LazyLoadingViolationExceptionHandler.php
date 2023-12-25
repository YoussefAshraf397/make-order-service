<?php

namespace App\BaseApp\Exceptions\Handlers;

class LazyLoadingViolationExceptionHandler
{
    public function __invoke($exception)
    {
        return  response()->json(
            [
                'errors' => [
                    [
                        'status' => 406,
                        'title' => 'lazy_Loading',
                        'detail' => $exception->getMessage()
                    ]
                ]
            ],
            406
        );
    }
}
