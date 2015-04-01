<?php

/**
 * Class Query
 */
class Query
{

    /**
     * Sql query
     *
     * @var string
     */
    public $query;

    /**
     * Sql query parameters
     *
     * @var array
     */
    public $parameters;

    /**
     * Result set of the query
     *
     * @var array
     */
    public $result_set;

    /**
     * Was the query executed successfully
     *
     * @var bool
     */
    public $success;

    /**
     * Sql error description
     *
     * @var string
     */
    public $error;

    /**
     * Sql error code (driver specific)
     *
     * @var int
     */
    public $error_code;

    /**
     * Last inserted id by the query
     *
     * @var string
     */
    public $inserted_id;

    /**
     * Row count of the result set
     *
     * @var int
     */
    public $row_count;

    // Sql error constants
    const ERROR_DUPLICATE = 1062;
    const ERROR_TABLE_NOT_EXISTS = 1146;

    /**
     * Query constructor
     *
     * Build query object
     *
     * @param string $error       error description
     * @param int    $error_code  error code
     * @param array  $parameters  sql parameters array
     * @param string $query       sql query
     * @param array  $result_set  result set
     * @param bool   $success     is query successfully executed
     * @param string $inserted_id inserted id by the query
     */
    function __construct($error, $error_code, $parameters, $query, $result_set, $success, $inserted_id)
    {
        $this->error = is_null($error) ? '' : $error;
        $this->error_code = $error_code;
        $this->parameters = $parameters;
        $this->query = $query;
        $this->result_set = $result_set;
        $this->row_count = count($result_set);
        $this->success = $success;
        $this->inserted_id = $inserted_id;
    }
}