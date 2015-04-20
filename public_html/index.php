<?php

/*
 * If installation is present, run it.
 */
if (file_exists('install.php'))
{
    require_once 'install.php';
    exit();
}

/*
 * Boot-up the application.
 */
require_once '../vendor/trident/trident.php';

$app = new Trident_Application('../application/configuration/configuration.json');