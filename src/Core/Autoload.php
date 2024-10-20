<?php

namespace Core;

class Autoload
{
    public static function register(string $rootPath):void
    {
        $autoload = function (string $className) use ($rootPath) {
            $className = str_replace("\\", "/", $className);
            $path = "$rootPath/$className.php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };
        spl_autoload_register($autoload);
    }
}