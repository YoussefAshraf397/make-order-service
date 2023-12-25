<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Put extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
    ) {
        parent::__construct(
            methods: ['put'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
