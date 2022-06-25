<?php

namespace App\Middlewares;

class StartSessionMiddleware
{
    public static function boot($next, $request, $response)
    {
        session_start();

        return $next();
    }
}
