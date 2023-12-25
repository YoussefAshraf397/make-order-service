<?php

namespace Support\RouteAttributes\Attributes;

class WhereNumber extends Where
{
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->constraint = '[0-9]+';
    }
}
