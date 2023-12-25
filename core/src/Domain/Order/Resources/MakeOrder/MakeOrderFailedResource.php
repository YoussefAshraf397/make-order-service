<?php

namespace Domain\Order\Resources\MakeOrder;

use Domain\Order\Resources\OrderResourceInterface;

class MakeOrderFailedResource implements OrderResourceInterface
{
    public function message(): string
    {
        return 'make_order_failed';
    }

    public function status(): bool
    {
        return false;
    }

    public function statusCode(): int
    {
        return 500;
    }

    public function getData()
    {
        return null;
    }
}
