<?php

namespace Support\RouteAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class SkipModulePrefix implements RouteAttribute
{
    public function __construct(
        public string $prefix
    ) {
    }
}
