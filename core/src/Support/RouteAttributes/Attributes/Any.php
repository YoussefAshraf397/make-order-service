<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;
use Illuminate\Routing\Router;

#[Attribute(Attribute::TARGET_METHOD)]
class Any extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
        array|string $skipMiddleware = []
    ) {
        parent::__construct(
            methods: Router::$verbs,
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipModuleRouteName: $skipModuleRouteName,
            skipMiddleware:$skipMiddleware
        );
    }
}
