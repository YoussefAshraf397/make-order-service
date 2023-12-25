<?php

namespace App\BaseApp\Exceptions\Handlers;

class NotFoundModelExceptionHandler
{
    public function __invoke($request, $exception)
    {
        $debug = env('APP_DEBUG', false);
        if ($request->isJson() || $request->wantsJson()) {
            $title = 'resource_not_found';
            $detail = trans('BaseAppGeneral::app.Resource not found');


            if ($debug) {
                $title = $exception->getMessage() ?? '';
                $detail = $exception->getTrace();
            }
            return response()->json(
                [
                    'errors' => [
                        [
                            'status' => 404,
                            'title' => $title,
                            'detail' => $detail
                        ]
                    ]
                ],
                401
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
