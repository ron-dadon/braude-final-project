<?php

namespace Trident\Libraries;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;

class AbstractLibrary
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
     * Initialize the library.
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


}