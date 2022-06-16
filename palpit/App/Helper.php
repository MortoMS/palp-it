<?php

function autoloadClass($classPath)
{
    $pathFileClass = systemPath('/' . $classPath . '.php', ['\\', '/']);

    if (file_exists($pathFileClass)) {
        require_once $pathFileClass;

        return;
    }

    throw new Exception('Arquivo não encontrado no local: ' . $pathFileClass);
}

function systemPath(string $path = null, $delimiter = '/', $raiz = RAIZ)
{
    return str_replace($delimiter, DIRECTORY_SEPARATOR, $raiz . $path);
}

function env(string $name, $defaultValue = null)
{
    return (isset($_ENV[$name])) ? $_ENV[$name] : $defaultValue;
}
