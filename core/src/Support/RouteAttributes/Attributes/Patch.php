<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Patch extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
    ) {
        parent::__construct(
            methods: ['patch'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
