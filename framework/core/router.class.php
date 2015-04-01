<?php

/**
 * Class Router
 */
class Router
{

    /**
     * Routes array
     *
     * @var Route[]
     */
    protected $_routes;

    /**
     * Configuration object reference
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Router constructor
     *
     * Build object and set references
     *
     * @param Configuration $configuration
     */
    function __construct($configuration)
    {
        $this->_configuration = $configuration;
    }

    /**
     * Load routes file
     *
     * @param string $file routes file name
     *
     * @throws Trident_Exception
     */
    public function load($file)
    {
        if (!file_exists($file) || !is_readable($file))
        {
            throw new Trident_Exception("Router: file $file doesn't exists or is not readable");
        }
        if (($data = json_decode(file_get_contents($file), true)) === null)
        {
            throw new Trident_Exception("Router: file $file is corrupted or not a valid ini file");
        }
        foreach ($data['routes'] as $route)
        {
            $this->add($route['pattern'], $route['controller'], $route['method']);
        }
    }

    /**
     * Add new route
     *
     * Build new route object and add it to the routes array
     *
     * @param string $pattern    route pattern
     * @param string $controller route controller
     * @param string $method     route method
     */
    public function add($pattern, $controller, $method)
    {
        $this->_routes[] = new Route($controller . '_controller', $method, $pattern);
    }

    /**
     * Get route that match the supplied uri
     *
     * @param string $uri request uri
     *
     * @return Route|null
     */
    public function get_route($uri)
    {
        $uri = str_replace($this->_configuration->get('routes', 'base'), '', $uri);
        foreach ($this->_routes as $route)
        {
            if (preg_match($route->pattern, $uri, $parameters))
            {
                $parameters_values = [];
                foreach ($route->parameters as $parameter)
                {
                    if (array_key_exists($parameter, $parameters))
                    {
                        $parameters_values[] = $parameters[$parameter];
                    }
                }
                $route->parameters = $parameters_values;
                return $route;
            }
        }
        return null;
    }
}