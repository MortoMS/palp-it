<?php

namespace App\Middlewares;

class StartSessionMiddleware
{
    public function boot($next, $request, $response)
    {
        session_start();

        return $next();
    }
}
