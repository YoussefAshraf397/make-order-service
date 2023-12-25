<?php

namespace Domain\Order\DataTransferObject;

use Spatie\DataTransferObject\DataTransferObject;

class OrderDto extends DataTransferObject
{
    public array $products;

    public static function fromRequest($data): self
    {
        return new self([
            'products' => $data->products,
        ]);
    }
}
