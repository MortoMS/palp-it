<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'Helper.php';

spl_autoload_register("autoloadClass");

use App\Providers\DatabaseProvider;
use App\Providers\ConfigProvider;
use App\Providers\RequestProvider;

try {
    ConfigProvider::loadingENVFile();
    DatabaseProvider::getInstance();
    RequestProvider::router();

    require_once systemPath('/App/Routers.php');
} catch (Exception $e) {
    echo $e->getMessage();
} 
