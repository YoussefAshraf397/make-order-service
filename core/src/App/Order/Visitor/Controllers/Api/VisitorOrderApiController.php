<?php

namespace App\Order\Visitor\Controllers\Api;

use App\Order\Visitor\Requests\OrderRequest;
use App\Order\Visitor\ViewModels\MakeOrderViewModel;
use Domain\Order\Actions\PlaceOrder\MakeOrderAction;
use Domain\Order\DataTransferObject\OrderDto;
use Support\RouteAttributes\Attributes\Middleware;
use Support\RouteAttributes\Attributes\Post;
use Support\RouteAttributes\Attributes\Prefix;
use Support\RouteAttributes\Attributes\SkipModulePrefix;

#[
    SkipModulePrefix(''),
    Prefix('visitor/order'),
    Middleware('guest'),
]
class VisitorOrderApiController
{
    #[
        post(
            uri: 'make-order',
            name: 'make-order',
        )
    ]
    public function makeOrder(
        OrderRequest $orderRequest,
        MakeOrderAction $action
    ) {
        $orderDto = OrderDto::fromRequest((object)$orderRequest->all());
        return (new MakeOrderViewModel())->toResponses($action($orderDto));
    }
}
