<?php

namespace App\Models;

use App\Models\Model;

class UsuarioModel extends Model
{
    protected static $table = 'usuario';
    protected static $primaryKey = 'id_usuario';
    protected static $columns = [
        'id_usuario',
        'nome',
        'email',
        'senha',
        'sobre',
        'cidade',
        'receber',
        'confirmacao',
        'foto_p',
        'tipo_usuario',
        'criado_usuario'
    ];

}