<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Options extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
    ) {
        parent::__construct(
            methods: ['options'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
