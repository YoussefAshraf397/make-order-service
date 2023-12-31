<?php

namespace App\BaseApp\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class RouteServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
//        $this->mapApiRoutes();

//        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        // TODO enhance this
        if (env('PRODUCTION_LOAD_BALANCER') == 'alb') {
            $prefix = env('PRODUCTION_APP_PREFIX');
            // APIs
            Route::prefix("$prefix/api/v1/{language}")
                ->middleware(['api', 'Locale'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix("$prefix/api/v2/{language}")
                ->middleware(['api', 'Locale'])
                ->namespace($this->namespace)
                ->group(base_path('routes/v2/api.php'));

            // Web Routes
            Route::prefix("$prefix")
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        } else {
            // APIs
            Route::prefix('api/v1/{language}')
                ->middleware(['api', 'Locale'])
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('api/v2/{language}')
                ->middleware(['api', 'Locale'])
                ->namespace($this->namespace)
                ->group(base_path('routes/v2/api.php'));
        }
    }
}
