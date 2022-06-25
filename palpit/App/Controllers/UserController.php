<?php

namespace App\Controllers;

use App\Providers\AuthProvider;
use App\Providers\ViewProvider as View;
use App\Providers\ResponseProvider as Response;
use App\Providers\RequestProvider as Request;

class UserController
{
    public static function loginView(Request $request, Response $response)
    {
        return $response->view(
            'layout.blackLayout',
            [
                'title' => 'Inicio',
                'body' => View::render('pages.login')
            ]
        )->render();
    }

    public static function login(Request $request, Response $response)
    {
        $errors   = [];
        $email    = filter_var($request->getInput('email'), FILTER_VALIDATE_EMAIL);
        $password = filter_var($request->getInput('senha'));

        if (is_null($email) || empty($email)) {
            $errors['email'] = 'O campo email é inválido.';
        }

        if (
            is_null($password) ||
            empty($password) ||
            strlen($password) < 6 ||
            strlen($password) > 12
        ) {
            $errors['senha']  = 'O campo senha é inválido.';
        }

        if (count($errors) === 0) {
            if (AuthProvider::logar($email, $password)) {
                return $response->redirect('/');
            } else {
                $errors['login'] = 'Usuário ou/e senha inválido/s.';
            }
        }

        return $response->view(
            'layout.blackLayout',
            [
                'title' => 'Inicio',
                'body' => View::render('pages.login', [
                    "errors" => $errors
                ])
            ]
        )->render();
    }

    public static function logout(Request $request, Response $response)
    {
        AuthProvider::logout();

        return $response->redirect('/');
    }
}
