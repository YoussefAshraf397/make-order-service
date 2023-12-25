<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SkipMiddleware implements RouteAttribute
{
    public array $skipMiddlewares;

    public function __construct(
        ...$middleware
    ) {
        $this->skipMiddlewares = $middleware;
    }
}
