<?php

namespace Support\RouteAttributes;

use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class RouteAttributesServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    public function boot()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        if (!$this->shouldRegisterRoutes()) {
            return;
        }
//        dd(app()->path());
        (new RouteRegister())
            ->userRouter(app()->router)
            ->useWebMiddleware('web')
            ->useApiMiddleware('api', 'Locale', 'throttle:5000,1')
            ->useBasePath(app()->path())
            ->useRootNamespace(app()->getNamespace())
            ->registerAppRoutes();
    }

    private function shouldRegisterRoutes(): bool
    {
        if ($this->app->routesAreCached()) {
            return false;
        }
        return true;
    }
}
