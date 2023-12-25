<?php

namespace Support\RouteAttributes;

use ReflectionClass;
use Support\RouteAttributes\Attributes\Domain;
use Support\RouteAttributes\Attributes\Middleware;
use Support\RouteAttributes\Attributes\Prefix;
use Support\RouteAttributes\Attributes\RouteAttribute;
use Support\RouteAttributes\Attributes\SkipMiddleware;
use Support\RouteAttributes\Attributes\SkipModulePrefix;
use Support\RouteAttributes\Attributes\SnakeDelimiter;
use Support\RouteAttributes\Attributes\Where;

class ClassRouteAttributes
{
    private ReflectionClass $class;


    public function __construct(
        ReflectionClass $class,
        public bool $isWeb,
        public string $controllerNameSpace
    ) {
        $this->class = $class;
    }


    public function middleware(): array
    {
        /** @var Middleware $attribute */
        $attribute = $this->getAttribute(Middleware::class);
        return !$attribute ? [] : $attribute->middleware;
    }

    protected function getAttribute(string $attributeClass): ?RouteAttribute
    {
        $attributes = $this->class->getAttributes($attributeClass);
        /* @var $attributes array of RouteAttribute */
        return !count($attributes) ? null : $attributes[0]->newInstance();
    }

    public function domain(): ?string
    {
        /* @var $attribute Domain */
        $attribute = $this->getAttribute(Domain::class);
        return $attribute?->domain;
    }

    public function wheres(): array
    {
        $wheres = [];
        /** @var ReflectionClass[] $attributes */
        $attributes = $this->class->getAttributes(Where::class);
        foreach ($attributes as $attribute) {
            $attributeClass = $attribute->newInstance();
            $wheres[$attributeClass->param] = $attributeClass->constraint;
        }

        return $wheres;
    }

    public function prefix(): ?string
    {
        /** @var Prefix $attribute */
        $attribute = $this->getAttribute(Prefix::class);
        return $attribute?->prefix;
    }

    public function snakeDelimiter(): ?string
    {
        $attribute = $this->getAttribute(SnakeDelimiter::class);
        return $attribute?->delimiter;
    }

    public function skipModulePrefix(): bool
    {
        return (bool)count($this->class->getAttributes(SkipModulePrefix::class));
    }

    public function skipMiddleware(): array
    {
        $skipMiddleware = $this->getAttribute(SkipMiddleware::class);
        return !$skipMiddleware ? [] : $skipMiddleware->skipMiddlewares;
    }
}
