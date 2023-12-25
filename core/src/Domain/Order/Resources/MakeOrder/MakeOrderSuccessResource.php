<?php

namespace Domain\Order\Resources\MakeOrder;

use Domain\Order\Resources\OrderResourceInterface;

class MakeOrderSuccessResource implements OrderResourceInterface
{
    public function message(): string
    {
        return 'make_order_successfully';
    }

    public function status(): bool
    {
        return true;
    }

    public function statusCode(): int
    {
        return 200;
    }

    public function getData()
    {
        return null;
    }
}
