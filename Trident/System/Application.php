<?php

namespace Trident\System;

use \Trident\Exceptions\MissingApplicationNamespaceException;
use \Trident\Exceptions\MissingApplicationPathException;
use \Trident\Exceptions\MissingRoutesException;

class Application
{

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Debug
     */
    private $debug;

    private $applicationPath;

    function __construct($configuration, $debug)
    {
        $this->configuration = $configuration;
        $this->debug = $debug;
        $this->bootstrapApplication();
    }

    public function bootstrapApplication()
    {
        try
        {
            $routesFile = $this->configuration->item('system.routes');
        }
        catch (\InvalidArgumentException $e)
        {
            throw new MissingRoutesException("Missing routes files. Can't start application.");
        }
        try
        {
            $this->applicationPath = $this->configuration->item('application.path');
            spl_autoload_register([$this, "applicationAutoLoad"], false);
        }
        catch (\InvalidArgumentException $e)
        {
            throw new MissingApplicationPathException("Missing application path definition. Can't create application auto load.");
        }
        try
        {
            $applicationNamespace = $this->configuration->item('application.namespace');
        }
        catch (\InvalidArgumentException $e)
        {
            throw new MissingApplicationNamespaceException("Missing application namespace definition. Can't create application auto load.");
        }
        try
        {
            $production = $this->configuration->item('environment.production');
        }
        catch (\InvalidArgumentException $e)
        {
            $production = false;
        }
        try
        {
            $timeZone = $this->configuration->item('environment.zone');
        }
        catch (\InvalidArgumentException $e)
        {
            $timeZone = 'UTC';
        }
        try
        {
            $logsPath = $this->configuration->item('paths.logs');
        }
        catch (\InvalidArgumentException $e)
        {
            $logsPath = ini_get('error_log');
        }
        error_reporting($production ? 0 : E_ALL);
        date_default_timezone_set($timeZone);
        $request = new Request();
        $session = new Session();
        $log = new Log($logsPath);
        $router = new Router($routesFile, $request->getURI(), $applicationNamespace);
        $router->dispatch($request, $this->configuration, $log, $session);
        try
        {
            $debug = $this->configuration->item('system.debug');
        }
        catch (\InvalidArgumentException $e)
        {
            $debug = false;
        }
        if (!$production && $debug)
        {
            $this->debug->showInformation();
        }
    }

    public function applicationAutoLoad($class)
    {
        $path = $this->applicationPath . $class . ".php";
        if (file_exists($path))
        {
            require_once $path;
        }
    }
}