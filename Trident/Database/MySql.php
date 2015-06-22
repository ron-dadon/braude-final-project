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

use \PDO;
use \PDOException;
use \Trident\Exceptions\MySqlException;

/**
 * Class MySql
 *
 * A simple wrapper class for PHP's PDO.
 *
 * @package Trident\Database
 */
class MySql extends PDO
{

    /**
     * Database name.
     *
     * @var string
     */
    private $_database;

    /**
     * Initialize database connection.
     *
     * @param string $host     Database host address.
     * @param string $user     Database user name.
     * @param string $password Database user password.
     * @param string $database Database name.
     * @param bool   $emulate  Emulate prepared statements.
     *
     * @throws MySqlException
     */
    function __construct($host, $user, $password, $database, $emulate = true)
    {
        $dsn = "mysql:host=$host;dbname=$database;charset=UTF8";
        try
        {
            parent::__construct($dsn, $user, $password);
        }
        catch (\PDOException $e)
        {
            throw new MySqlException($e->getMessage(), $e->getCode(), $e);
        }
        if (!$emulate)
        {
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        }
        $this->_database = $database;
    }

    /**
     * Execute a query.
     *
     * @param Query $query The query to execute.
     *
     * @throws MySqlException
     * @return Result The result of the query.
     */
    public function executeQuery($query)
    {
        $statement = $this->prepare($query->getQuery());
        if ($statement === false)
        {
            throw new MySqlException("Can't prepare statement from query `" . $query->getQuery() . "`");
        }
        try
        {
            if ($statement->execute($query->getParameters()))
            {
                $result = new Result(true, 0, '', $this->lastInsertId(), $statement->fetchAll(PDO::FETCH_ASSOC));
            }
            else
            {
                $result = new Result(false, $statement->errorInfo()[1], $statement->errorInfo()[2]);
            }
            return $result;
        }
        catch (PDOException $e)
        {
            error_log($e->getMessage() . ": Error executing query " . $query->getQuery() . " with parameters " . implode(', ', $query->getParameters()));
            die();
        }
    }

    /**
     * Execute a transaction based on a series of queries.
     *
     * @param Query[] $queries Queries list.
     *
     * @return bool True if transaction completed successfully, false otherwise.
     */
    public function executeTransaction($queries)
    {
        if (!is_array($queries))
        {
            throw new \InvalidArgumentException("Transaction queries must be supplied in an array");
        }
        foreach ($queries as $query)
        {
            if (!($query instanceof Query))
            {
                throw new \InvalidArgumentException("Transactions queries must be a valid Query object");
            }
        }
        $this->beginTransaction();
        foreach ($queries as $query)
        {
            if (!$this->executeQuery($query)->isSuccess())
            {
                $this->rollBack();
                return false;
            }
        }
        return $this->commit();
    }

    /**
     * Check if MySql user have the required permission.
     *
     * @param string $permission Permission name.
     *
     * @return bool True if user got permission, false otherwise.
     *
     * @throws MySqlException
     */
    public function checkPermission($permission)
    {
        $permission = strtoupper($permission);
        $result = $this->executeQuery(new Query("SHOW GRANTS FOR CURRENT_USER"));
        if ($result->isSuccess())
        {
            $permissions = array_values($result->getResultSet()[0])[0];
            return strpos($permissions, $permission) !== false || strpos($permissions, "ALL PRIVILEGES") !== false;
        }
        return false;
    }

    /**
     * Check if table exists in the database.
     *
     * @param string $table Table name.
     *
     * @return bool True if table exists, false otherwise.
     *
     * @throws MySqlException
     */
    public function isTableExists($table)
    {
        $database = $this->_database;
        $result = $this->executeQuery(new Query("SHOW TABLES WHERE Tables_in_$database = ?", [$table]));
        return $result->isSuccess() && $result->getRowCount() === 1;
    }
}