<?php

namespace Trident\Database;

/**
 * Class Query
 *
 * A database query wrapper that includes a query string and the query parameters.
 *
 * @package Trident\Database
 */
class Query
{

    /**
     * Query string.
     *
     * @var string
     */
    protected $query;

    /**
     * Query parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Creates a new query.
     *
     * @param string $query      Query string.
     * @param array  $parameters Query parameters.
     */
    function __construct($query, $parameters = [])
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }

    /**
     * Query parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Query parameters.
     *
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        if (!is_array($parameters))
        {
            throw new \InvalidArgumentException("Query parameters must be an array");
        }
        $this->parameters = $parameters;
    }

    /**
     * Query string.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Query string.
     *
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

}