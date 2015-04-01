<?php

/**
 * Class View
 */
abstract class View
{

    /**
     * Public path of the application
     *
     * @var string
     */
    protected $_public_path;

    /**
     * Shared view folder path
     *
     * @var string
     */
    protected $_shared_view_path;

    /**
     * View data array
     *
     * @var array
     */
    protected $_data;

    /**
     * Configuration object reference
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Request object reference
     *
     * @var Request
     */
    protected $_request;

    /**
     * View constructor
     *
     * Build view object, set references and data
     *
     * @param Configuration $configuration configuration reference
     * @param Request       $request       request reference
     * @param array         $data          view data array
     *
     * @throws Trident_Exception
     */
    function __construct($configuration, $request, $data = [])
    {
        $this->_data = $data;
        $this->_configuration = $configuration;
        $this->_request = $request;
        $this->_public_path = $this->_configuration->get('paths', 'public');
        $this->_shared_view_path = $this->_configuration->get('paths', 'application') . $this->_configuration->get('paths', 'views') . 'shared' . DS;
        spl_autoload_register([$this, 'shared_view_auto_load']);
    }

    /**
     * Implement to render the view
     */
    public abstract function render();

    /**
     * Load shared view
     *
     * @param string $view shared view name (without _view suffix)
     *
     * @return View
     */
    protected function shared_view($view)
    {
        $view .= '_view';
        $view = strtolower($view);
        return new $view($this->_configuration, $this->_request, $this->_data);
    }

    /**
     * Load a library
     *
     * @param string $library library name (without _library suffix)
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
     * Escape html special characters
     *
     * @param string $var variable to escape
     *
     * @return string
     */
    protected function escape($var)
    {
        return htmlspecialchars($var, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Output the public path
     * Used for shorter syntax inside the view
     */
    protected function public_path()
    {
        echo $this->_public_path;
    }

    /**
     * Shared view auto loader
     *
     * @param string $class class name
     */
    private function shared_view_auto_load($class)
    {
        if (file_exists($file = $this->_shared_view_path . $class . '.class.php'))
        {
            require_once $file;
            return;
        }
    }
}