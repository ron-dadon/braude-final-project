<?php


namespace Trident\ORM;

use \Trident\Database\Query;
use \Trident\Database\Result;
use \Trident\Database\MySql;
use \Trident\Exceptions\EntityNotFoundException;
use \Trident\Exceptions\MySqlException;

class Mapper
{

    /**
     * MySql instance.
     *
     * @var MySql
     */
    protected $mySql;

    /**
     * Application namespace.
     *
     * @var string
     */
    private $_namespace;

    function __construct($mySql, $namespace)
    {
        $this->mySql = $mySql;
        $this->_namespace = $namespace;
    }

    /**
     * Find an entity using SELECT query.
     *
     * @param string          $entity          Entity class name.
     * @param string          $where           Where condition.
     * @param array           $whereParameters Where condition parameters array.
     * @param string|null     $order           Order statement.
     * @param string|int|null $limit           Limit statement.
     * @param string|int|null $offset          Offset statement.
     *
     * @return null|Entity[] Entity instances array on success, otherwise null.
     * @throws EntityNotFoundException
     * @throws MySqlException
     */
    public function find($entity, $where = "1", $whereParameters = [], $order = null, $limit = null, $offset = null)
    {
        $entity = "\\" . $this->_namespace . "\\Entities\\" . $entity;
        if (!class_exists($entity))
        {
            throw new EntityNotFoundException("Can't create instance of entity `$entity`");
        }
        /** @var Entity $entity */
        $object = new $entity();
        list($table, $prefix) = [$object->getTable(), $object->getPrefix()];
        $queryString = "SELECT * FROM $table WHERE $where";
        $queryString .= ($order !== null ? " ORDER BY $order" : "");
        $queryString .= ($limit !== null ? " LIMIT $limit" : "");
        $queryString .= ($offset !== null ? " OFFSET $offset" : "");
        $query = new Query($queryString, $whereParameters);
        $result = $this->mySql->executeQuery($query);
        if ($result->isSuccess())
        {
            $data = $result->getResultSet();
            $objects = [];
            foreach ($data as $row)
            {
                $object = new $entity();
                foreach ($row as $key => $value)
                {
                    $key = str_replace($prefix, "", $key);
                    $object->$key = $value;
                }
                $objects[] = $object;
            }
            return $objects;
        }
        else
        {
            return null;
        }
    }

    /**
     * Find an entity by ID.
     *
     * @param string     $entity Entity class name.
     * @param int|string $id     Entity primary key value.
     * @param string $where Additional where condition.
     * @return null|Entity Returns the entity instance if found, otherwise returns null.
     *
     * @throws EntityNotFoundException
     * @throws MySqlException
     */
    public function findById($entity, $id, $where = "")
    {
        $entityClass = "\\" . $this->_namespace . "\\Entities\\" . $entity;
        if (!class_exists($entityClass))
        {
            throw new EntityNotFoundException("Can't create instance of entity `$entity`");
        }
        /** @var Entity $object */
        $object = new $entityClass();
        list($primary, $prefix) = [$object->getPrimary(), $object->getPrefix()];
        $result = $this->find($entity, "$where AND $prefix$primary = :id", [':id' => $id]);
        if ($result !== null)
        {
            return $result[0];
        }
        return null;
    }

    /**
     * Save entity to the database.
     * If entity already exists, uses UPDATE statement, else uses INSERT.
     *
     * @param Entity $entity Entity to save.
     *
     * @return Result Query result object.
     */
    public function save($entity)
    {
        if (!$entity instanceof Entity)
        {
            throw new \InvalidArgumentException("ORM mapper save method argument must be an Entity object");
        }
        list($primary, $prefix, $table) = [$entity->getPrimary(), $entity->getPrefix(), $entity->getTable()];
        $data = $entity->toArray();
        $foreign = array_map(function ($item)
            {
                if ($item instanceof Entity)
                {
                    return $item;
                }
                return null;
            }, $data);
        $arrays = array_map(function ($item)
            {
                if (is_array($item))
                {
                    return $item;
                }
                return null;
            }, $data);
        $foreign = array_filter($foreign);
        $arrays = array_filter($arrays);
        if ($entity->$primary === null)
        {
            $fields = array_keys($data);
            $fields = array_diff($fields, array_merge(array_keys($foreign), array_keys($arrays)));
            $fieldList = implode(', ', $fields);
            $parametersList = ":" . implode(', :', $fields);
            $queryString = "INSERT INTO $table ($fieldList) VALUES ($parametersList)";
            $query = new Query($queryString, $data);
            return $this->mySql->executeQuery($query);
        }
        else
        {
            $fields = array_diff(array_keys($data), array_merge(array_keys($foreign), array_keys($arrays), [$prefix . $primary]));
            $fields = array_map(function ($item)
                {
                    return "$item = :$item";
                }, $fields);
            $fieldList = implode(', ', $fields);
            $queryString = "UPDATE $table SET $fieldList WHERE $prefix$primary = :$prefix$primary";
            $query = new Query($queryString, $data);
            return $this->mySql->executeQuery($query);
        }
    }

    /**
     * Delete an entity from the database.
     *
     * @param Entity $entity Entity to delete.
     *
     * @return Result Query result object.
     */
    public function delete($entity)
    {
        if (!$entity instanceof Entity)
        {
            throw new \InvalidArgumentException("ORM mapper delete method argument must be an Entity object");
        }
        list($primary, $prefix, $table) = [$entity->getPrimary(), $entity->getPrefix(), $entity->getTable()];
        if ($entity->$primary === null)
        {
            throw new \InvalidArgumentException("ORM mapper can't delete Entity without primary key value");
        }
        $query = new Query("DELETE FROM $table WHERE $prefix$primary = :$primary", [":$primary" => $entity->$primary]);
        return $this->mySql->executeQuery($query);
    }
}