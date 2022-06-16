<?php

namespace App\Providers;

use PDO;
use App\Providers\ConfigProvider;

class DatabaseProvider
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::createDatabaseConnection();
            self::setDefaultConfig();
        }

        return self::$instance;
    }

    private static function createDatabaseConnection()
    {
        $data = ConfigProvider::getConfig('database');

        self::$instance = new PDO(
            (
                "mysql:host={$data['DB_HOST']};".
                "port={$data['DB_PORT']}".
                "dbname={$data['DB_DATABASE']}"
            ),
            $data['DB_USER'],
            $data['DB_PASS']
        ); 
    }

    private static function setDefaultConfig()
    {
        self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
