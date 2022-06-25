<?php

namespace App\Middlewares;

use App\Providers\AuthProvider;
use App\Providers\ResponseProvider as Response;
use App\Providers\RequestProvider as Request;

class AuthStatusMiddleware
{
    public static function is_on($next, Request $request,  Response$response)
    {
        if (AuthProvider::check()) {
            return $next();
        }

        return $response->redirect('/');
    }

    public static function is_off($next, Request $request, Response $response)
    {
        if (!AuthProvider::check()) {
            return $next();
        }

        return $response->redirect('/');
    }
}