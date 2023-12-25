<?php

namespace App\BaseApp\Exceptions\Handlers;

class NotFoundRouteExceptionHandler
{
    public function __invoke($request, $exception)
    {
        if ($request->isJson() || $request->wantsJson()) {
            return response()->json(
                [
                    'status' => 406,
                    'title' => 'route_notFound',
                    'detail' => trans('BaseAppGeneral::app.Route not Found')
                ],
                403
            );
        } else {
            return response()->view(
                'BaseAppGeneral::errors.' . 404,
                array(
                    'exception' => $exception
                )
            );
        }
    }
}
