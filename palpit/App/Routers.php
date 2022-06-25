<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\AuthStatusMiddleware;
use App\Middlewares\StartSessionMiddleware;
use App\Providers\RequestProvider as Router;

Router::setMiddleware('startSession', [StartSessionMiddleware::class, 'boot']);

Router::get('/', [HomeController::class, 'index']);

Router::group('/', function() {
    Router::get('login', [UserController::class, 'loginView']);
    Router::post('login', [UserController::class, 'login']);
}, [[AuthStatusMiddleware::class, 'is_off']]);

Router::group('/', function() {
    Router::get('/logout', [UserController::class, 'logout']);
}, [[AuthStatusMiddleware::class, 'is_on']]);

