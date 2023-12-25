<?php

namespace Domain\Order\Resources\Validations;

use Domain\Order\Resources\OrderResourceInterface;

class ValidateMakeOrderSuccessResource implements OrderResourceInterface
{
    public function message(): string
    {
        return 'order_created_successfully';
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
