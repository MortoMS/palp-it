<?php

namespace App\Controllers;

use App\Models\AreaModel;
use App\Providers\ResponseProvider as Response;
use App\Providers\RequestProvider as Request;
use App\Providers\ViewProvider as View;

class SingUpController
{
    public static function singUpView(Request $request, Response $response)
    {
        $areas = AreaModel::get();

        return $response->view(
            'layout.blackLayout',
            [
                'title' => 'Inicio',
                'body' => View::render('pages.singup', [
                    "areas" => $areas
                ])
            ]
        )->render();
    }

    public static function singUp(Request $request, Response $response)
    {
        var_dump($request->getInput());
    }
}
