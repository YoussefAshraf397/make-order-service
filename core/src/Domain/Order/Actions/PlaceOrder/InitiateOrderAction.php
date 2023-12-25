<?php

namespace Domain\Order\Actions\PlaceOrder;

use Domain\Models\Order\Order;
use Domain\Models\Order\OrderProduct;
use Illuminate\Database\Eloquent\Model;

class InitiateOrderAction
{
    public function __invoke(Model $product, Order $order, int $quantity): void
    {
        OrderProduct::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
    }
}
