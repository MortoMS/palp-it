<?php

namespace App\Providers;

use App\Models\UsuarioModel;
use App\Repositories\UsuarioRepository;

class AuthProvider
{
    const INDEXUSER = 'USER';
    private static $userData;
    
    public static function user(): UsuarioModel
    {
        return self::$userData;
    }

    private static function validationPassword(
        string $password, 
        string $passwordHash
    ): bool {
        if (password_verify($password, $passwordHash)) {
            return true;
        }

        return false;
    }

    public static function check(): bool
    {
        if (!isset(self::$userData)) { 
            if (isset($_SESSION[self::INDEXUSER])) {
                self::$userData = $_SESSION[self::INDEXUSER];
            }
        }

        if (isset(self::$userData) && get_class(self::$userData) === 'App\Models\UsuarioModel') {
            return true;   
        }

        return false;
    }

    public static function logar(string $email, string $senha)
    {
        $user = UsuarioRepository::getUserByEmail($email);

        if (!$user) {
            return false;
        }

        if (!self::validationPassword($senha, $user->senha)) {
            return false;
        }

        self::$userData            = $user;
        $_SESSION[self::INDEXUSER] = $user;

        return true;
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
    }
}
