<?php

namespace Domain\Order\Resources\Validations;

use Domain\Order\Resources\OrderResourceInterface;

class ValidateProductIngredientInStockFailedResource implements OrderResourceInterface
{
    public function message(): string
    {
        return 'product_ingredient_not_enough';
    }

    public function status(): bool
    {
        return false;
    }

    public function statusCode(): int
    {
        return 422;
    }

    public function getData()
    {
        return null;
    }
}
