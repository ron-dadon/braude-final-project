<?php


namespace Trident\Database;

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