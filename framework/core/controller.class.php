<?php

/**
 * Class Controller
 */
abstract class Controller
{

    /**
     * Request object reference
     *
     * @var Request
     */
    protected $_request;

    /**
     * Configuration object reference
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Database object
     *
     * @var Database
     */
    protected $_database;

    /**
     * Controller constructor
     *
     * Set object references and register views auto load function
     *
     * @param Configuration $configuration configuration reference
     * @param Request       $request       request reference
     */
    function __construct($configuration, $request)
    {
        $this->_configuration = $configuration;
        $this->_request = $request;
        spl_autoload_register([$this, '_view_auto_load'], false);
    }

    /**
     * Load database
     *
     * Build database object
     *
     * @throws Trident_Exception
     */
    public function load_database()
    {
        if ($this->_configuration->is_section_exists('database'))
        {
            if (is_null($this->_database))
            {
                try
                {
                    $this->_database = new Database($this->_configuration);
                }
                catch (PDOException $e)
                {
                    // MySql error code 1045 means that access was denied for the user
                    if ($e->getCode() === 1045)
                    {
                        die('Database access denied. Please check your configuration.');
                    }
                    // MySql error code 1049 means that the database doesn't exists
                    if ($e->getCode() === 1049)
                    {
                        die('The database your tried to connect to doesn\'t exists or unavailable. Please check your configuration.');
                    }
                    // MySql error code 2002 means that database host can't be reached
                    if ($e->getCode() === 2002)
                    {
                        die('Database host access denied or database host is unavailable. Please check your configuration.');
                    }
                    var_dump($e);
                    die('Database initialization error. Please check your configuration.');
                }
            }
        }
        else
        {
            throw new Trident_Exception("Controller: database configuration is missing");
        }
    }

    /**
     * Load a model
     *
     * @param string $model model name without the suffix
     *
     * @return Model
     */
    public function load_model($model)
    {
        $model .= '_model';
        $model = strtolower($model);
        return new $model($this->_configuration, $this->_request, $this->_database);
    }

    /**
     * Load a view
     *
     * Build view object and pass data array to it.
     * If $view is set to null, the view that will be created is according to the calling controller and method,
     * for example: Controller "Main_Controller" executes "load_view" within "index" method, will load the view
     * class called "Main_Index_View".
     * If $view is specified, the view that will be created is according to the calling controller only,
     * for example: Controller "Main_Controller" executes "load_view" within "index" method with $view = "about" will
     * load the view class called "Main_About_View".
     *
     * @param array $data data array to pass to the view
     * @param null  $view optional view name (without the _view suffix and controller name prefix)
     *
     * @return View
     * @throws Trident_Exception
     */
    protected function load_view($data = [], $view = null)
    {
        if (is_null($view))
        {
            $view = debug_backtrace()[1]['function'];
            $view = $this->_get_name() . '_' . $view . '_view';
        }
        return new $view($this->_configuration, $this->_request, $data);
    }

    /**
     * Load a library
     *
     * @param string $library library name (without the _library suffix)
     *
     * @return Library
     */
    protected function load_library($library)
    {
        $library .= '_library';
        $library = strtolower($library);
        return new $library($this->_configuration, $this->_request);
    }

    /**
     * Redirection
     *
     * Redirect the application to another uri.
     *
     * @param string $uri      redirection uri
     * @param bool   $use_base use public path as base of the uri (prefix)
     *
     * @throws Trident_Exception
     */
    protected function redirect($uri, $use_base = true)
    {
        header('location: ' . ($use_base ? $this->_configuration->get('paths', 'public') : '') . $uri);
        exit();
    }

    /**
     * Download a file
     *
     * @param string $file path to file
     * @param string $file_name optional file name
     *
     * @throws Trident_Exception
     */
    public function download_file($file, $file_name = '')
    {
        if (!file_exists($file) || !is_readable($file))
        {
            throw new Trident_Exception("Controller: file $file doesn't exists or is not readable for download");
        }
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . ($file_name === '' ? basename($file) : $file_name) . "\"");
        readfile($file);
        exit();
    }

    /**
     * View auto load function
     *
     * @param string $class class name
     *
     * @throws Trident_Exception
     */
    private function _view_auto_load($class)
    {
        $file =
            $this->_configuration->get('paths', 'application') .
            $this->_configuration->get('paths', 'views') .
            $this->_get_name() . DS . $class . '.class.php';
        if (file_exists($file))
        {
            require_once $file;
            return;
        }
    }

    /**
     * Get controller name (without the _controller suffix)
     *
     * @return string
     */
    private function _get_name()
    {
        return str_replace('_controller', '', strtolower(get_class($this)));
    }

    /**
     * Output 404 response
     *
     * If response file is specified in the configuration, tries to load this file.
     * In case of failure, fall back to simple 'Error 404' text output.
     */
    protected function response_404()
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

}