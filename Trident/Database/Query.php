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