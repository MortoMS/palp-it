<?php

namespace App\Repositories;

use App\Models\UsuarioModel;

class UsuarioRepository
{
    public static function getUserByEmail($email)
    {
        $result = UsuarioModel::get([
            ['email', '=', $email]
        ], 1);

        return (count($result) !== 1) ? false : $result[0];
    }
}
