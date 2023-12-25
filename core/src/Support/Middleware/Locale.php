<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // if we're still using this alb => increment the segment
        if (env('PRODUCTION_LOAD_BALANCER') == 'alb') {
            // URL format $prefix/api/v1/{language}/
            $languageCode = $request->segment(4);
        } else {
            // URL format api/v1/{language}/
            $languageCode = $request->segment(3);
        }

        // URL format api/v1/{language}/
        $availableLocales = config("translatable.locales");
        $languageCode = strtolower($languageCode);

        if (!in_array($languageCode, $availableLocales)) {
            $languageCode = env('DEFAULT_LANGUAGE', 'en');
        }
        LaravelLocalization::setLocale($languageCode);
        app()->setLocale($languageCode);
        $request->route()->forgetParameter('language');
        return $next($request);
    }
}
