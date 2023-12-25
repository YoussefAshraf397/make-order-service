<?php

namespace App\BaseApp\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Support\Singleton\SessionSingleton;
use Support\Singleton\SettingCurrentAcademicYearSingleton;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->app->bind(ParserInterface::class, DocumentParser::class);
//        Model::preventLazyLoading();
//        Validator::extend(
//            'mobile',
//            function ($attribute, $value, $parameters, $validator) {
//                if ($value == '') {
//                    return true;
//                }
//                if (!trim($value) && intval($value) != 0) {
//                    return true;
//                }
//                return preg_match('/^\d+$/', $value) && strlen($value) == 11;
//            }
//        );
//
//        Paginator::useBootstrap();
//
//        Factory::guessFactoryNamesUsing(
//            function (string $modelName) {
//                // We can also customise where our factories live too if we want:
//                $namespace = 'Database\\Factories\\';
//
//                // Here we are getting the model name from the class namespace
//                $modelName = Str::afterLast($modelName, '\\');
//
//                // Finally we'll build up the full class path where
//                // Laravel will find our model factory
//                return $namespace . $modelName . 'Factory';
//            }
//        );
    }
}
