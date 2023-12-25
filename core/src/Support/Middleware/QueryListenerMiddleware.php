<?php

namespace Support\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class QueryListenerMiddleware
{
    public function handle($request, $next)
    {
        if (App::isProduction()) {
            return $next($request);
        }

        DB::enableQueryLog();
        $response = $next($request);

        $queries = DB::getQueryLog();

        $totalTime = array_sum(array_column($queries, 'time'));
        $queries = array_map(function ($query) {
            $query['time'] = round($query['time'], 3);
            return $query;
        }, $queries);

        $response->headers->set('X-Total-Queries', count($queries));
        $response->headers->set('X-Total-Time', $totalTime);

        return $response;
    }
}
