<?php

/**
 * Class Application
 */
class Application
{

    /**
     * Configuration object
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Router object
     *
     * @var Router
     */
    protected $_router;

    /**
     * Request object
     *
     * @var Request
     */
    protected $_request;

    /**
     * Script start time
     *
     * @var float
     */
    protected $_start_time;

    /**
     * Application constructor
     *
     * Constructs and initializes important objects such as configuration and router.
     * Defining global application environment such as production, debug and time zone.
     *
     * @throws Trident_Exception
     */
    function __construct()
    {
        $this->_start_time = microtime(true);
        $this->_configuration = new Configuration();
        $this->_router = new Router($this->_configuration);
        $this->_request = new Request(true);
        $this->_configuration->load(CONFIGURATION_FILE);
        $routes_file = $this->_configuration->get('paths', 'application') . $this->_configuration->get('routes', 'file');
        $this->_router->load($routes_file);
        spl_autoload_register([$this, '_application_auto_load'], false);
        if ($this->_configuration->get('application', 'production'))
        {
            error_reporting(0);
        }
        try
        {
            date_default_timezone_set($this->_configuration->get('application', 'time_zone'));
        }
        catch (Trident_Exception $e)
        {
            date_default_timezone_set('UTC');
        }
    }

    /**
     * Start the application
     *
     * Parses the route from the request uri.
     * Runs the appropriate controller method.
     * Outputs debug information if configuration allows it.
     *
     * @throws Trident_Exception
     */
    public function start()
    {
        $route = $this->_router->get_route($this->_request->server->get('REQUEST_URI'));
        if ($route === null)
        {
            $this->_response_404();
        }
        if (!class_exists($route->controller))
        {
            $this->_response_404();
        }
        $controller = new $route->controller($this->_configuration, $this->_request);
        if (!is_callable([$controller, $route->method]))
        {
            $this->_response_404();
        }
        if (call_user_func_array([$controller, $route->method], $route->parameters) === false)
        {
            $this->_response_404();
        }
        if (!$this->_configuration->get('application', 'production') && $this->_configuration->get('application', 'debug'))
        {
            $this->_debug_information();
        }
    }

    /**
     * Outputs debug information
     *
     * Echos important debug information such as processing time, memory usage, global arrays etc.
     */
    private function _debug_information()
    {
        echo PHP_EOL . '<pre>' . PHP_EOL;
        echo 'Debug information:' . PHP_EOL;
        echo '------------------' . PHP_EOL;
        $process_time = number_format(microtime(true) - $this->_start_time, 2);
        $memory_usage = memory_get_peak_usage() / 1024;
        $allocated_memory = memory_get_peak_usage(true) / 1024;
        try
        {
            $request_uri = $this->_request->server->get('REQUEST_URI');
        }
        catch (Trident_Exception $e)
        {
            $request_uri = 'n/a';
        }
        $request_type = $this->_request->type;
        $get_array = print_r($this->_request->get->get_all(), true);
        $post_array = print_r($this->_request->post->get_all(), true);
        $server_array = print_r($this->_request->server->get_all(), true);
        $cookie_array = print_r($this->_request->cookie->get_all(), true);
        $session_array = print_r($this->_request->session->get_all(), true);
        $files_array = print_r($this->_request->files->get_all(), true);
        echo "Process time: $process_time [ms]" . PHP_EOL;
        echo "Memory usage: $memory_usage [kb]" . PHP_EOL;
        echo "Allocated memory: $allocated_memory [kb]" . PHP_EOL;
        echo "Request URI: $request_uri" . PHP_EOL;
        echo "Request type: $request_type" . PHP_EOL;
        echo "Cookie array: $cookie_array" . PHP_EOL;
        echo "Files array: $files_array" . PHP_EOL;
        echo "Get array: $get_array" . PHP_EOL;
        echo "Post array: $post_array" . PHP_EOL;
        echo "Server array: $server_array" . PHP_EOL;
        echo "Session array: $session_array" . PHP_EOL;
        echo '</pre>';
    }

    /**
     * Output 404 response
     *
     * If response file is specified in the configuration, tries to load this file.
     * In case of failure, fall back to simple 'Error 404' text output.
     */
    private function _response_404()
    {
        header('HTTP/1.0 404 Not Found');
        try
        {
            $app_name = $this->_configuration->get('application', 'name');
            $app_path = $this->_configuration->get('paths', 'public');
            $file = $this->_configuration->get('paths', 'application') . $this->_configuration->get('responses', '404');
            if (file_exists($file) && is_readable($file))
            {
                require_once $file;
            }
            else
            {
                echo 'Error 404';
            }
        }
        catch (Trident_Exception $e)
        {
            echo 'Error 404';
        }
        exit();
    }

    /**
     * Application auto loader
     *
     * Auto loading for controllers, models and entities based of path specified in the configuration
     *
     * @param string $class class name
     *
     * @return void
     * @throws Trident_Exception
     */
    private function _application_auto_load($class)
    {
        $class = strtolower($class);
        $search = ['controllers', 'models', 'entities'];
        foreach ($search as $path)
        {
            if (file_exists($file = $this->_configuration->get('paths', 'application') . $this->_configuration->get('paths', $path) . $class . '.class.php'))
            {
                require_once $file;
                return;
            }
        }
    }
}