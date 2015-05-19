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
        return new $modelName($this->_configuration, $this->_mysql, $this->_orm, $this->_log, $this->_request,
                              $this->_session, $this->_libraries);
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
     * Sends a response to the client.
     *
     * @param int $code Response code.
     * @param bool $showMessage Display response error message.
     * @param string $message Response message.
     */
    public function response($code, $showMessage = true, $message = null)
    {
        $status_codes = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        ];
        if ($status_codes[$code] !== null)
        {
            $status_string = $code . ' ' . $status_codes[$code];
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $code);
            if ($showMessage)
            {
                echo "<h1>$status_string</h1>";
                if (!is_null($message))
                {
                    echo "<p>$message</p>";
                }
            }
            exit();
        }
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
     * @return null|Mapper
     */
    public function getORM()
    {
        return $this->_orm;
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