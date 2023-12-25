<?php

namespace Support\RouteAttributes\Attributes;

class WhereAlphaNumeric extends Where
{
    public function __construct(string $param)
    {
        $this->param = $param;
        $this->constraint = '[a-zA-Z0-9]+';
    }
}
