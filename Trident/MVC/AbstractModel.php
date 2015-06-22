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

namespace Trident\MVC;

use \Trident\System\Request;
use \Trident\System\Configuration;
use \Trident\System\Log;
use \Trident\System\Session;
use \Trident\Database\MySql;
use \Trident\ORM\Mapper;
use \Trident\Libraries\Libraries;
use \Trident\Exceptions\ModelNotFoundException;

/**
 * Class AbstractModel
 *
 * Base model class for creating models.
 * Provides access to Trident framework core instances.
 * Provides MySql and ORM objects.
 *
 * @package Trident\MVC
 */
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