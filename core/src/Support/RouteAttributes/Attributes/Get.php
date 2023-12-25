<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Get extends Route implements RouteAttribute
{
    /**
     * @param string $uri
     * @param string $name
     * @param array|string $middleware
     */
    public function __construct(
        public string $uri,
        public string $name,
        array|string $middleware = [],
        bool $skipModuleRouteName = false,
        array|string $skipMiddleware = []
    ) {
        parent::__construct(
            methods: ['get'],
            uri: $uri,
            name: $name,
            middleware: $middleware,
            skipMiddleware: $skipMiddleware,
            skipModuleRouteName: $skipModuleRouteName
        );
    }
}
