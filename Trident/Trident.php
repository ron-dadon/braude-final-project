<?php

if (!defined('CONFIGURATION_FILE') || !defined('VENDOR_PATH'))
{
    die("Can't start application. Definitions are missing.");
}

function tridentAutoLoader($class)
{
    $path = VENDOR_PATH . $class . ".php";
    if (file_exists($path))
    {
        require_once $path;
    }
}

spl_autoload_register("tridentAutoLoader", false);

$app = new Trident\System\Application(
    new \Trident\System\Configuration(CONFIGURATION_FILE),
    new Trident\System\Debug()
);