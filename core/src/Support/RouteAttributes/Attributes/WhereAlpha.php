<?php

namespace Support\RouteAttributes\Attributes;

class WhereAlpha extends Where
{
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->constraint = '[a-zA-Z]+';
    }
}
