<?php

// Validate that the developer defined the configuration file constant
if (!defined('CONFIGURATION_FILE'))
{
    die('Missing configuration definition.');
}

// Base path to the framework folder
define('TRIDENT_BASE', dirname(__FILE__));
// Short alias for DIRECTORY_SEPARATOR
define('DS', DIRECTORY_SEPARATOR);

/**
 * Trident framework auto load function
 *
 * This function loads all the core and libraries when they are required
 *
 * @param string $class class name
 */
function trident_autoload($class)
{
    $class = strtolower($class);
    $locations = [
        'core',
        'core' . DS . 'database',
        'core' . DS . 'request',
        'core' . DS . 'router',
        'libs'
    ];
    foreach ($locations as $path)
    {
        if (file_exists($file = TRIDENT_BASE . DS . $path . DS . $class . '.class.php'))
        {
            require_once $file;
            return;
        }
    }
}

// Register the auto load function
spl_autoload_register('trident_autoload', false);