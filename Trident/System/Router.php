<?php

namespace Trident\System;

use \Trident\Exceptions\ControllerNotFoundException;
use \Trident\Exceptions\IOException;
use \Trident\Exceptions\JsonParseException;
use \Trident\Exceptions\MethodNotFoundException;
use \Trident\Exceptions\RouteNotFoundException;
use \Trident\Exceptions\RouterDispatchException;

class Router
{

    /**
     * Default route.
     * This route will be executed if no match is found.
     *
     * @var Route
     */
    private $_default;

    /**
     * Application routes.
     *
     * @var Route[]
     */
    private $_routes;

    /**
     * Routes prefix to ignore.
     *
     * @var string
     */
    private $_prefix;

    /**
     * Routes application namespace.
     *
     * @var string
     */
    private $_namespace;

    /**
     * Request URI.
     *
     * @var string
     */
    private $_uri;

    /**
     * Initialize router.
     *
     * @param string $file      Routes file path.
     * @param string $uri       Request URI.
     * @param string $namespace Application namespace.
     *
     * @throws IOException
     * @throws JsonParseException
     */
    function __construct($file, $uri, $namespace = "")
    {
        if (!file_exists($file))
        {
            throw new IOException("Required file $file doesn't exists");
        }
        $data = json_decode(file_get_contents($file), true);
        if ($data === false)
        {
            throw new JsonParseException("Error parsing JSON routes file $file");
        }
        if (isset($data['prefix']))
        {
            $this->_prefix = $data['prefix'];
        }
        else
        {
            $this->_prefix = "";
        }
        if (!isset($data['default']))
        {
            $this->_default = null;
        }
        else
        {
            $default = $data['default'];
            if (isset($default['pattern']) && isset($default['controller']) && isset($default['method']))
            {
                $this->_default = new Route($default['controller'], $default['method'], $default['pattern']);
            }
            else
            {
                $this->_default = null;
            }
        }
        $this->_routes = [];
        if (isset($data['routes']) && is_array($data['routes']))
        {
            $routes = $data['routes'];
            foreach ($routes as $route)
            {
                if (isset($route['pattern']) && isset($route['controller']) && isset($route['method']))
                {
                    $this->_routes[] = new Route($route['controller'], $route['method'], $route['pattern']);
                }
            }
        }
        $this->_uri = $uri;
        $this->_namespace = $namespace;
    }

    /**
     * Search routes for a match to the supplied URI.
     *
     * @param string $uri Request URI.
     *
     * @return null|Route Matched Route instance on match, default Route instance otherwise.
     */
    private function _match_route($uri)
    {
        $uri = str_replace($this->_prefix, '', $uri);
        $uri = '/' . trim($uri, '/');
        foreach ($this->_routes as $key => $route)
        {
            if (preg_match($route->getPattern(), $uri, $parameters))
            {
                $dispatch_parameters = [];
                foreach ($route->getParameters() as $parameter)
                {
                    $dispatch_parameters[] = $parameters[$parameter];
                }
                $route->setParameters($dispatch_parameters);
                return $route;
            }
        }
        return $this->_default;
    }

    /**
     * Dispatch the route.
     *
     * @param Request       $request       Request instance.
     * @param Configuration $configuration Configuration instance.
     * @param Log           $log           Log instance.
     * @param Session       $session       Session instance.
     *
     * @throws ControllerNotFoundException
     * @throws MethodNotFoundException
     * @throws RouteNotFoundException
     * @throws RouterDispatchException
     */
    public function dispatch($request, $configuration, $log, $session)
    {
        if (($route = $this->_match_route($request->getURI())) !== null)
        {
            $controller = $this->_namespace . "\\Controllers\\" . $route->getController();
            if (!class_exists($controller))
            {
                throw new ControllerNotFoundException("AbstractController `$controller` doesn't exists");
            }
            $controller = new $controller($configuration, $log, $request, $session);
            if (!method_exists($controller, $method = $route->getMethod()))
            {
                $controller = $route->getController();
                throw new MethodNotFoundException("Method `$method` doesn't exists in controller `$controller`");
            }
            if (call_user_func_array([$controller, $route->getMethod()], $route->getParameters()) === false)
            {
                $controller = $route->getController();
                $method = $route->getMethod();
                $parameters = print_r($route->getParameters(), true);
                throw new RouterDispatchException("Dispatch of route `$controller->$method($parameters)` failed");
            }
        }
        else
        {
            $uri = $request->getURI();
            throw new RouteNotFoundException("No route was found for URI `$uri`");
        }
    }

}