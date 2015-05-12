<?php


namespace Trident\MVC;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;
use \Trident\Database\MySql;
use \Trident\ORM\Mapper;
use \Trident\Libraries\Libraries;

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
     * @return Mapper
     */
    public function getORM()
    {
        return $this->_orm;
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