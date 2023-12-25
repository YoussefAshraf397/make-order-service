<?php

namespace App\BaseApp\Exceptions\Handlers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ValidationExceptionHandler
{
    public function __invoke($request, $exception): Response|JsonResponse
    {
        if ($request->isJson() || $request->wantsJson()) {
            $errorArray = [];
            $errors = $exception->errors();
            foreach ($errors as $name => $error) {
                $errorArray[] = [
                    'status' => 422,
                    'title' => $name,
                    'detail' => $error[0],
                ];
            }
            return response()->json(
                [
                'errors' => $errorArray
                ],
                422
            );
        } else {
            return response()->view(
                'BaseAppGeneral::errors.' . 403,
                array(
                    'exception' => $exception
                )
            );
        }
    }
}
