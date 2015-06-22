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

namespace Trident\Database;

/**
 * Class Result
 *
 * Provides a full set or query result data.
 *
 * @package Trident\Database
 */
class Result
{

    /**
     * Success or failure of query.
     *
     * @var bool
     */
    protected $success;

    /**
     * Error code.
     *
     * @var int
     */
    protected $errorCode;

    /**
     * Error string.
     *
     * @var string
     */
    protected $errorString;

    /**
     * Row count.
     *
     * @var int
     */
    protected $rowCount;

    /**
     * Result set.
     *
     * @var array
     */
    protected $resultSet;

    /**
     * Last inserted ID.
     *
     * @var string
     */
    protected $lastId;

    /**
     * @param $errorCode
     * @param $errorString
     * @param $lastId
     * @param $resultSet
     * @param $success
     */
    function __construct($success, $errorCode = 0, $errorString = '', $lastId = '', $resultSet = [])
    {
        $this->success = $success;
        $this->errorCode = $errorCode;
        $this->errorString = $errorString;
        $this->lastId = $lastId;
        $this->resultSet = $resultSet;
        $this->rowCount = count($resultSet);
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorString()
    {
        return $this->errorString;
    }

    /**
     * @return string
     */
    public function getLastId()
    {
        return $this->lastId;
    }

    /**
     * @return array
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * @return int
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

}