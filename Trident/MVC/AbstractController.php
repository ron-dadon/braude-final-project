<?php

namespace Trident\MVC;

use \Trident\Exceptions\IOException;
use \Trident\Exceptions\ModelNotFoundException;
use \Trident\Exceptions\ViewNotFoundException;
use \Trident\ORM\Mapper;
use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;
use Trident\Database\MySql;
use \Trident\Libraries\Libraries;

class AbstractController
{

    /**
     * Request instance.
     *
     * @var Request
     */
    private $_request;

    /**
     * Configuration instance.
     *
     * @var Configuration
     */
    private $_configuration;

    /**
     * Log instance.
     *
     * @var Log
     */
    private $_log;

    /**
     * Session instance.
     *
     * @var Session
     */
    private $_session;

    /**
     * Database instance.
     *
     * @var MySql|null
     */
    private $_mysql;

    /**
     * ORM mapper instance.
     *
     * @var Mapper
     */
    private $_orm;

    /**
     * Libraries instance.
     *
     * @var Libraries
     */
    private $_libraries;

    /**
     * Initialize the controller.
     *
     * @param Configuration $configuration Configuration instance.
     * @param Log           $log           Log instance.
     * @param Request       $request       Request instance.
     * @param Session       $session       Session instance.
     */
    function __construct($configuration, $log, $request, $session)
    {
        $this->_configuration = $configuration;
        $this->_log = $log;
        $this->_request = $request;
        $this->_session = $session;
        $this->_libraries = new Libraries($configuration, $log, $request, $session);
        $this->_mysql = null;
        $this->_orm = null;
    }

    /**
     * Load MySql using the configuration.
     */
    public function loadMySql()
    {
        if ($this->_mysql !== null)
        {
            return;
        }
        try
        {
            $host = $this->_configuration->item('database.host');
            $user = $this->_configuration->item('database.user');
            $password = $this->_configuration->item('database.password');
            $name = $this->_configuration->item('database.name');
            $emulate = !$this->_configuration->item('environment.production');
            $this->_mysql = new MySql($host, $user, $password, $name, $emulate);
        }
        catch (\InvalidArgumentException $e)
        {
            $this->_mysql = null;
        }
    }

    /**
     * Loads ORM mapper instance. If MySql object was not loaded before, loads MySql object as well.
     */
    public function loadORM()
    {
        if ($this->_orm === null)
        {
            if ($this->_mysql === null)
            {
                $this->loadMySql();
            }
            $this->_orm = new Mapper($this->_mysql, $this->_configuration->item('application.namespace'));
        }
    }

    /**
     * Creates a Model object.
     *
     * @param string $model Model to create.
     *
     * @return AbstractModel
     * @throws ModelNotFoundException
     */
    public function loadModel($model)
    {
        try
        {
            $namespace = $this->_configuration->item('application.namespace');
        }
        catch (\InvalidArgumentException $e)
        {
            $namespace = "";
        }
        $modelName = $namespace . "\\Models\\$model";
        if (!class_exists($modelName))
        {
            throw new ModelNotFoundException("Can't load model `$modelName`");
        }
        return new $modelName($this->_configuration, $this->_mysql, $this->_log, $this->_request, $this->_session);
    }

    /**
     * Redirect the application.
     *
     * @param string $to            Redirection URI.
     * @param bool   $usePublicPath Set to true to prepend the application's public path.
     */
    public function redirect($to, $usePublicPath = true)
    {
        if ($usePublicPath)
        {
            try
            {
                $path = $this->_configuration->item('paths.public');
            }
            catch (\InvalidArgumentException $e)
            {
                $path = "";
            }
            $to = $path . $to;
        }
        header("location: $to");
        exit();
    }

    /**
     * Download a file.
     *
     * @param string $file     Path to file.
     * @param string $fileName Optional file name.
     *
     * @throws IOException
     */
    protected function downloadFile($file, $fileName = '')
    {
        if (!file_exists($file) || !is_readable($file))
        {
            throw new IOException("Can't read file `$file` for download");
        }
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . ($fileName === '' ? basename($file) : $fileName) . "\"");
        readfile($file);
        exit();
    }

    /**
     * Download data as a file.
     *
     * @param string $data     File data.
     * @param string $fileName File name.
     */
    protected function downloadData($data, $fileName)
    {
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"$fileName\"");
        echo $data;
        exit();
    }

    /**
     * Load view instance.
     * If $view is not specified, loads the view according to the calling callable.
     *
     * @param array $viewData View data array.
     * @param null  $viewName View name.
     *
     * @throws ViewNotFoundException
     * @return AbstractView View instance.
     */
    protected function getView($viewData = [], $viewName = null)
    {
        try
        {
            $namespace = $this->_configuration->item('application.namespace');
        }
        catch (\InvalidArgumentException $e)
        {
            $namespace = "";
        }
        if (is_null($viewName))
        {
            $viewName = debug_backtrace()[1]['function'];
            $reflect = new \ReflectionClass($this);
            $class = $reflect->getShortName();
            $viewName = "$class\\$viewName";
        }
        $viewName = $namespace . "\\Views\\$viewName";
        if (!class_exists($viewName))
        {
            throw new ViewNotFoundException("Can't load view `$viewName`");
        }
        return new $viewName($this->_configuration, $viewData);
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * @return Log
     */
    public function getLog()
    {
        return $this->_log;
    }

    /**
     * @return null|MySql
     */
    public function getMysql()
    {
        return $this->_mysql;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->_session;
    }

    /**
     * @return Libraries
     */
    public function getLibraries()
    {
        return $this->_libraries;
    }
}