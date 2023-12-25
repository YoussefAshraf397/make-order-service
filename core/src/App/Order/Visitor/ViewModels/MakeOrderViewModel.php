<?php

namespace App\Order\Visitor\ViewModels;

use App\BaseApp\ViewModel\Api\BaseApiViewModel;
use Domain\Order\Resources\OrderResourceInterface;
use Illuminate\Http\JsonResponse;

class MakeOrderViewModel extends BaseApiViewModel
{
    public function toResponses(OrderResourceInterface $orderResource): JsonResponse
    {
        if ($orderResource->status()) {
            return response()->json([
                "meta" => [
                    "message" => trans($this->module() . "app." . $orderResource->message()),
                    "status" => $orderResource->status(),
                ]
            ]);
        }
        return response()->json([
            "errors" => [
                    "title" => "place_order_error",
                    "detail" => trans($this->module() . "app." . $orderResource->message()),
                    "status" => $orderResource->status(),
            ]
        ], $orderResource->statusCode());
    }
    public function module(): string
    {
        return 'OrderVisitor::';
    }
}
