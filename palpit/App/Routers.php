<?php

use App\Controllers\HomeController;
use App\Controllers\SingUpController;
use App\Controllers\UserController;
use App\Middlewares\AuthStatusMiddleware;
use App\Middlewares\StartSessionMiddleware;
use App\Providers\RequestProvider as Router;

Router::setMiddleware('startSession', [StartSessionMiddleware::class, 'boot']);

Router::get('/', [HomeController::class, 'index']);

Router::group('/', function() {
    // Login
    Router::get('login', [UserController::class, 'loginView']);
    Router::post('login', [UserController::class, 'login']);

    // Cadastro
    Router::get('cadastro', [SingUpController::class, 'singUpView']);
    Router::post('cadastro', [SingUpController::class, 'singUp']);
}, [[AuthStatusMiddleware::class, 'is_off']]);

Router::group('/', function() {
    
}, [[AuthStatusMiddleware::class, 'is_on']]);

Router::get('/logout', [UserController::class, 'logout']);
