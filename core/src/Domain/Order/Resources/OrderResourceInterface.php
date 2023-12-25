<?php

namespace Domain\Order\Resources;

interface OrderResourceInterface
{
    public function message(): string;

    public function status(): bool;

    public function statusCode(): int;

    public function getData();
}
