<?php

namespace App\Models;

use App\Models\Model;

class AreaModel extends Model
{
    protected static $table = 'area';
    protected static $primaryKey = 'id_area';
    protected static $columns = [
        'id_area',
        'nome_area'
    ];
}