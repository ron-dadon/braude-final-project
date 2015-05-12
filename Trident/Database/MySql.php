<?php

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