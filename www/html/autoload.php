<?php

spl_autoload_register("gbStandardAutoload");
function gbStandardAutoload($className)
{
    $dirs = [
        'models',
        'helpers',
        'controllers',
        'config',
    ];
    $found = false;
    foreach ($dirs as $dir) {
        $fileName = __DIR__ . '/' . $dir . '/' . $className . '.php';
        if (is_file($fileName)) {
            require_once($fileName);
            $found = true;
        }
    }
    if (!$found) {
        throw new Exception('Unable to load ' . $className);
    }
    return true;
}