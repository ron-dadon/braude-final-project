<?php


namespace Trident\MVC;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;
use \Trident\Database\MySql;
use \Trident\ORM\Mapper;
use \Trident\Libraries\Libraries;
use \Trident\Exceptions\ModelNotFoundException;

abstract class AbstractModel
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
     * Initialize model.
     *
     * @param Configuration $configuration
     * @param Mapper        $orm
     * @param MySql         $mySql
     * @param Log           $log
     * @param Request       $request
     * @param Session       $session
     * @param Libraries     $libraries
     */
    function __construct($configuration, $mySql, $orm, $log, $request, $session, $libraries)
    {
        $this->_configuration = $configuration;
        $this->_mysql = $mySql;
        $this->_orm = $orm;
        $this->_log = $log;
        $this->_request = $request;
        $this->_session = $session;
        $this->_libraries = $libraries;
    }

    /**
     * @return Configuration
     */
    protected function getConfiguration()
    {
        return $this->_configuration;
    }

    /**
     * @return Log
     */
    protected function getLog()
    {
        return $this->_log;
    }

    /**
     * @return Mapper
     */
    protected function getORM()
    {
        return $this->_orm;
    }

    /**
     * @return null|MySql
     */
    protected function getMysql()
    {
        return $this->_mysql;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->_session;
    }

    /**
     * @return Libraries
     */
    protected  function getLibraries()
    {
        return $this->_libraries;
    }

    /**
     * Creates a Model object.
     *
     * @param string $model Model to create.
     *
     * @return AbstractModel
     * @throws ModelNotFoundException
     */
    protected function loadModel($model)
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

}