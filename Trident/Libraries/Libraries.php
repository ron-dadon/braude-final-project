<?php


namespace Trident\Libraries;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;
use \Trident\Exceptions\LibraryNotFoundException;

/**
 * Class Libraries
 *
 * @package Trident\Libraries
 */
class Libraries
{

    /**
     * Loaded libraries array.
     *
     * @var AbstractLibrary[]
     */
    private $_libs;

    /**
     * Application namespace.
     *
     * @var string
     */
    private $_namespace;

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
        $this->_namespace = $this->_configuration->item('application.namespace');
        $this->_libs = [];
    }

    /**
     * Get a loaded library.
     *
     * @param string $name Library name.
     *
     * @return AbstractLibrary
     */
    function __get($name)
    {
        if (!isset($this->_libs[$name]))
        {
            throw new \InvalidArgumentException("Library `$name` is not loaded");
        }
        return $this->_libs[$name];
    }

    /**
     * Load library instance.
     *
     * @param string $library Library name.
     *
     * @throws LibraryNotFoundException
     */
    public function load($library)
    {
        $libraryName = "\\" . $this->_namespace . "\\Libraries\\" . $library;
        if (!class_exists($libraryName))
        {
            throw new LibraryNotFoundException("Can't load library `$library`");
        }
        if (!isset($this->_libs[$library]))
        {
            $this->_libs[$library] = new $libraryName($this->_configuration, $this->_libs, $this->_request, $this->_session);
        }
    }

} 