<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Delete extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
    ) {
        parent::__construct(
            methods: ['delete'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
