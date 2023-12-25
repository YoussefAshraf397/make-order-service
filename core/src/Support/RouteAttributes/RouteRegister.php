<?php

namespace Support\RouteAttributes;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use ReflectionAttribute;
use ReflectionClass;
use SplFileInfo;
use Support\RouteAttributes\Attributes\Route;
use Support\RouteAttributes\Attributes\RouteAttribute;
use Support\RouteAttributes\Attributes\Where;
use Support\RouteAttributes\Attributes\WhereAttribute;
use Symfony\Component\Finder\Finder;
use Throwable;

//use Mcamara\LaravelLocalization\LaravelLocalization;

class RouteRegister
{
    protected string $basePath;

    protected array $routeName = [];

    protected string $rootNamespace;

    protected Router $router;

    protected array $webMiddlewares;

    private array $apiMiddleware;

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;
        return $this;
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = $basePath;
        return $this;
    }

    public function userRouter(Router $router): self
    {
        $this->router = $router;
        return $this;
    }

    public function useWebMiddleware(...$middleware): self
    {
        $this->webMiddlewares = $middleware;
        return $this;
    }

    public function useApiMiddleware(...$middleware): self
    {
        $this->apiMiddleware = $middleware;
        return $this;
    }

    public function registerAppRoutes(): void
    {
        $files = (new Finder())->files()
            ->name('*Controller.php')
            ->notName('*ApiController.php')
            ->in(
                app()->basePath()
                    . DIRECTORY_SEPARATOR
                    . 'src'
                    . DIRECTORY_SEPARATOR
                    . 'App'
                    . DIRECTORY_SEPARATOR
                    . '*'
                    . DIRECTORY_SEPARATOR
                    . '*'
                    . DIRECTORY_SEPARATOR
                    . 'Controllers'
                    . DIRECTORY_SEPARATOR
            );
        //        dd($files);
        collect($files)->each(fn (SplFileInfo $fileInfo) => $this->registerFile($fileInfo, true));
        $apiFiles = (new Finder())->files()
            ->name('*ApiController.php')
            ->in(
                app()->basePath()
                    . DIRECTORY_SEPARATOR
                    . 'src'
                    . DIRECTORY_SEPARATOR
                    . 'App'
                    . DIRECTORY_SEPARATOR
                    . '*'
                    . DIRECTORY_SEPARATOR
                    . '*'
                    . DIRECTORY_SEPARATOR
                    . 'Controllers'
                    . DIRECTORY_SEPARATOR
                    . 'Api'
                    . DIRECTORY_SEPARATOR
            );
        collect($apiFiles)->each(fn (SplFileInfo $fileInfo) => $this->registerFile($fileInfo, false));
    }

    public function registerFile(string|SplFileInfo $path, bool $web)
    {
        if (is_string($path)) {
            $path = new SplFileInfo($path);
        }
        $fullyQualifiedClassName = $this->fullQualifiedClassNameFromFile($path);
        $this->routeName = explode('\\', $fullyQualifiedClassName);
        $this->processAttributes($fullyQualifiedClassName, $web);
    }

    protected function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = trim(
            Str::replaceFirst(app()->basePath() . '/src/App/', '', $file->getRealPath()),
            DIRECTORY_SEPARATOR
        );

        $class = str_replace(
            [DIRECTORY_SEPARATOR, 'App\\'],
            ['\\', app()->getNamespace()],
            ucfirst(Str::replaceLast('.php', '', $class))
        );

        return $this->rootNamespace . $class;
    }

    protected function processAttributes(string $className, bool $web): void
    {
        if (!class_exists($className)) {
            return;
        }

        $class = new ReflectionClass($className);

        $classNameSpace = $class->getNamespaceName();

        $classRouteAttributes = new ClassRouteAttributes($class, $web, $classNameSpace);


        $prefix = $this->handlePrefix($classRouteAttributes);

        $this->router->prefix($prefix)
            ->group(fn () => $this->registerRoutes($class, $classRouteAttributes));
    }

    protected function handlePrefix(ClassRouteAttributes $classRouteAttributes): string
    {
        $prefix = '';
        if (env('PRODUCTION_LOAD_BALANCER') == 'alb') {
            $prefix = env('PRODUCTION_APP_PREFIX') . '/';
        }
        // check if Api Endpoint and prefix of api and version of it
        if (!$classRouteAttributes->isWeb) {
            $checkIfHasVersion = preg_match_all('/.V*?(\d+)$/', $classRouteAttributes->controllerNameSpace, $matches);
            $version = $checkIfHasVersion ? (int)$matches[1][0] : 1;
            $prefix .= "api/v${version}/{language}/";
        } else {
            $prefix .= LaravelLocalization::setLocale() . '/';
        }
        $prefix .= $classRouteAttributes->skipModulePrefix()
            ? ''
            : Str::snake(
                $this->routeName[1],
                $classRouteAttributes->snakeDelimiter()
                    ? $classRouteAttributes->snakeDelimiter()
                    : '_'
            )
            . '/' .
            Str::snake(
                $this->routeName[2],
                $classRouteAttributes->snakeDelimiter()
                    ? $classRouteAttributes->snakeDelimiter()
                    : '_'
            );
        if ($classRouteAttributes->prefix()) {
            $prefix .= $classRouteAttributes->prefix();
        }
        return $prefix;
    }

    protected function registerRoutes(
        ReflectionClass $class,
        ClassRouteAttributes $classRouteAttributes
    ): void {
        foreach ($class->getMethods() as $method) {
            $attributes = $method->getAttributes(RouteAttribute::class, ReflectionAttribute::IS_INSTANCEOF);
            $wheresAttributes = $method->getAttributes(WhereAttribute::class, ReflectionAttribute::IS_INSTANCEOF);

            foreach ($attributes as $attribute) {
                try {
                    $attributeClass = $attribute->newInstance();
                } catch (Throwable) {
                    continue;
                }

                if (!$attributeClass instanceof Route) {
                    continue;
                }

                $httpMethods = $attributeClass->methods;

                $action = $method->getName() === '__invoke'
                    ? $class->getName()
                    : [$class->getName(), $method->getName()];

                $route = $this->router->addRoute($httpMethods, $attributeClass->uri, $action);

                $name = $this->handleName(
                    $attributeClass,
                    $classRouteAttributes->controllerNameSpace,
                    $classRouteAttributes->isWeb
                );

                $route->name($name);

                !$classRouteAttributes->domain() ?? $route->domain($classRouteAttributes->domain());

                $wheres = $classRouteAttributes->wheres();
                foreach ($wheresAttributes as $wheresAttribute) {
                    /** @var Where $wheresAttributeClass */
                    $wheresAttributeClass = $wheresAttribute->newInstance();

                    // This also overrides class wheres if the same param is used
                    $wheres[$wheresAttributeClass->param] = $wheresAttributeClass->constraint;
                }
                if (!empty($wheres)) {
                    $route->setWheres($wheres);
                }

                $classMiddleware = array_values($classRouteAttributes->middleware());
                $methodMiddleware = array_values($attributeClass->middleware);
                $generalMiddleware = $classRouteAttributes->isWeb ?
                    array_values($this->webMiddlewares) : array_values($this->apiMiddleware);
                /**
                 * @no-named-arguments
                 * TODO fix this the proper way, gives an error of DuplicateArrayKey in psalm checks
                 * learn more here https://psalm.dev/docs/running_psalm/issues/DuplicateArrayKey/
                 */
                $route->middleware([...$generalMiddleware, ...$classMiddleware, ...$methodMiddleware]);

                // Without middleware
                $route->withoutMiddleware($attributeClass->skipMiddleware);
            }
        }
    }

    protected function handleName(Route $route, string $controllerNamespace, bool $isWeb): string
    {
        $name = '';
        if (!$isWeb) {
            $checkIfHasVersion = preg_match_all('/.V*?(\d+)$/', $controllerNamespace, $matches);
            $name .= $checkIfHasVersion ? 'api.v' . $matches[1][0] . '.' : 'api.';
        }
        $name .= $route->skipModuleRouteName
            ? $route->name
            : Str::snake($this->routeName[1])
            . '.'
            . Str::snake($this->routeName[2])
            . '.'
            . $route->name;
        return $name;
    }
}
