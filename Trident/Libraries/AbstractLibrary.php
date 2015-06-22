<?php
/**
 * Trident Framework - PHP MVC Framework
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 Ron Dadon
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Trident\Libraries;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;

/**
 * Class AbstractLibrary
 *
 * Base abstract class for building libraries.
 * Provides access to core Trident instance.
 *
 * @package Trident\Libraries
 */
abstract class AbstractLibrary
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