<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;

#[Attribute(Attribute::TARGET_METHOD)]
class Route implements RouteAttribute
{
    public array $middleware;

    public array $skipMiddleware;

    public function __construct(
        public array $methods,
        public string $uri,
        public string $name,
        array|string $middleware = [],
        array|string $skipMiddleware = [],
        public bool $skipModuleRouteName = false,
    ) {
        $this->methods = array_map(
            static fn (string $verb) => in_array(
                $upperVerb = strtoupper($verb),
                Router::$verbs
            )
                ? $upperVerb
                : $verb,
            $methods
        );
        $this->middleware = Arr::wrap($middleware);
        $this->skipMiddleware = Arr::wrap($skipMiddleware);
    }
}
