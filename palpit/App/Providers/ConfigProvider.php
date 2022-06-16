<?php

namespace App\Providers;

use Exception;

class ConfigProvider
{
    public static function loadingENVFile(string $fileName = '.env', string $path = null)
    {
        $path = self::existsFile($path . '/'. $fileName);
        $vars = file_get_contents($path);

        if (preg_match_all('/(([A-Z_]+)\=(.*))/', $vars, $result)) {
            if (count($result) >= 3) {
                foreach ($result[2] as $index => $keyVars) {
                    $key   = $keyVars;
                    $value = (isset($result[3][$index])) ? $result[3][$index] : '';

                    putenv($key . '=' . $value);
                }
            }
        }

        $_ENV = getenv();
    }

    public static function getConfig(string $nameFileConfig)
    {
        $path = self::existsFile("/config/" . $nameFileConfig . '.php');
    
        return include_once $path;
    }

    private static function existsFile(string $path = null): string
    {
        $path = systemPath($path);

        if (!file_exists($path)) {
            throw new Exception('Arquivo não encontrado');
        }

        return $path;
    }
}
