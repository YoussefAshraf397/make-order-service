<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Post extends Route
{
    public function __construct(
        string $uri,
        string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
        array|string $skipMiddleware = []
    ) {
        parent::__construct(
            methods: ['post'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipMiddleware: $skipMiddleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
