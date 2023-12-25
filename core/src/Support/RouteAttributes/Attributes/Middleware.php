<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Middleware implements RouteAttribute
{
    public array $middleware = [];

    public function __construct(...$middleware)
    {
        $this->middleware = $middleware;
    }
}
