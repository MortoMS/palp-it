<?php

namespace App\Controllers;

use App\Models\AreaModel;
use App\Providers\ResponseProvider as Response;
use App\Providers\RequestProvider as Request;
use App\Providers\ViewProvider as View;
use App\Exceptions\ValidationException;
use App\Providers\ValidationProvider;
use Exception;

class SingUpController
{
    public static function singUpView(
        Request $request,
        Response $response,
        array $data = [],
        array $errors = [],
        string $error = ""
    ) {
        $areas = AreaModel::get();

        return $response->view(
            'layout.blackLayout',
            [
                'title' => 'Inicio',
                'body' => View::render('pages.singup', [
                    "areas"  => $areas,
                    "data"   => $data,
                    "errors" => $errors,
                    "error"  => $error
                ])
            ]
        )->render();
    }

    public static function singUp(Request $request, Response $response)
    {
        try {
            $data = $request->getInput();

            ValidationProvider::validation($data, [
                "nome"    => ["required", "length_min:6", "length_max:100"],
                "email"   => ["required", "email", "length_max:100"],
                "senha"   => ["required", "length_min:6", "length_max:100"],
                "receber" => ["required", "bool"],
                "area"    => ["required", "number", function(string $campo, array $data) {
                    if (array_key_exists($campo, $data)) {
                        if (AreaModel::find($data[$campo])) {
                            return true;
                        }

                        return "Area referente ao id {$data[$campo]} não encontrada";
                    }

                    return false;
                }]
            ]);
        } catch (ValidationException $e) {
            return self::singUpView(
                $request,
                $response,
                $data,
                $e->getMessageValition()
            );
        } catch (Exception $e) {
            return self::singUpView(
                $request,
                $response,
                $data,
                [],
                $e->getMessage()
            );
        } 
    }
}
