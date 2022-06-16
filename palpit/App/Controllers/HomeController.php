<?php

namespace App\Controllers;

use App\Providers\ResponseProvider as Response;
use App\Providers\RequestProvider as Request;
use App\Providers\ViewProvider as View;

class HomeController
{
    public function index(Request $request, Response $response)
    {
        return $response->view(
            'layout.defaultLayout',
            [
                'title' => 'Inicio',
                'body' => View::render('pages.homepage')
            ]
        )->render();
    }
}
