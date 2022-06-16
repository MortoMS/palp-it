<?php

use App\Controllers\HomeController;
use App\Middlewares\StartSessionMiddleware;
use App\Providers\RequestProvider as Router;

Router::setMiddleware('startSession', [StartSessionMiddleware::class, 'boot']);

Router::get('/', [HomeController::class, 'index']);

Router::group('/admin', function() {
    Router::get('/teste', [HomeController::class, 'index']);
});
