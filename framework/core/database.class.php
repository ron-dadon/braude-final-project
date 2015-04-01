<?php

/**
 * Class Database
 */
class Database extends PDO
{
    /**
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Class constructor
     *
     * Initialize PDO base object using the database credentials from the configuration
     *
     * @param Configuration $configuration
     */
    public function __construct($configuration)
    {
        $this->_configuration = $configuration;
        parent::__construct(
            $this->_configuration->get('database', 'type') .
            ':host=' . $this->_configuration->get('database', 'host') .
            ';dbname=' . $this->_configuration->get('database', 'database'),
            $this->_configuration->get('database', 'user'), $this->_configuration->get('database', 'password'),
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $this->_configuration->get('database', 'charset') . "'"));
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Executes a sql query
     *
     * @param string     $query      query
     * @param array|null $parameters parameters array
     *
     * @return Query
     */
    public function run_query($query, $parameters = null)
    {
        $statement = $this->prepare($query);
        if ($statement === false)
        {
            $q = new Query(
                $this->errorInfo()[2],
                $this->errorInfo()[1],
                $parameters,
                $query,
                [],
                false,
                0
            );
            return $q;
        }
        $success = $statement->execute($parameters);
        $q = new Query(
            $statement->errorInfo()[2],
            $statement->errorInfo()[1],
            $parameters,
            $query,
            $statement->errorInfo()[0] !== '00000' ? [] : $statement->fetchAll(PDO::FETCH_ASSOC),
            $success,
            $this->lastInsertId()
        );
        return $q;
    }

    /**
     * Perform INSERT statement on an entity
     *
     * @param Entity $entity                entity object
     * @param string $table                 table name
     * @param bool   $entity_name_as_prefix use entity name (without the _entity suffix) as field name prefix
     *
     * @return Query
     */
    public function insert_entity($entity, $table, $entity_name_as_prefix = true)
    {
        $fields = $entity->get_fields();
        $fields_names = array_keys($fields);
        $prefix = '';
        if ($entity_name_as_prefix)
        {
            $prefix = $entity->get_name() . '_';
        }
        $fields_list = $prefix . implode(', ' . $prefix, $fields_names);
        $parameters_list = ':' . implode(', :', $fields_names);
        $q = "INSERT INTO $table ($fields_list) VALUES ($parameters_list)";
        $parameters_values = [];
        foreach ($fields as $key => $value)
        {
            $parameters_values[':' . $key] = $value;
        }
        return $this->run_query($q, $parameters_values);
    }

    /**
     * Perform UPDATE statement on an entity
     *
     * @param Entity $entity                entity object
     * @param string $table                 table name
     * @param string $primary               primary field name (without prefix if one exists)
     * @param bool   $entity_name_as_prefix use entity name (without the _entity suffix) as field name prefix
     *
     * @return Query
     */
    public function update_entity($entity, $table, $primary, $entity_name_as_prefix = true)
    {
        $fields = $entity->get_fields();
        $fields_names = array_keys($fields);
        if (($index = array_search($primary, $fields_names)) !== false)
        {
            unset($fields_names[$index]);
        }
        $prefix = '';
        if ($entity_name_as_prefix)
        {
            $prefix = $entity->get_name() . '_';
        }
        $fields_list = [];
        foreach ($fields_names as $name)
        {
            $fields_list[] = $prefix . $name . ' = :' . $name;
        }
        $fields_list = implode(', ', $fields_list);
        $q = "UPDATE $table SET $fields_list WHERE $prefix" . "$primary = :$primary";
        $parameters_values = [];
        foreach ($fields as $key => $value)
        {
            $parameters_values[':' . $key] = $value;
        }
        return $this->run_query($q, $parameters_values);
    }

    /**
     * Perform DELETE statement on an entity
     *
     * @param Entity $entity                entity object
     * @param string $table                 table name
     * @param string $primary               primary field name (without prefix if one exists)
     * @param bool   $entity_name_as_prefix use entity name (without the _entity suffix) as field name prefix
     *
     * @return Query
     */
    public function delete_entity($entity, $table, $primary, $entity_name_as_prefix = true)
    {
        $prefix = '';
        if ($entity_name_as_prefix)
        {
            $prefix = $entity->get_name() . '_';
        }
        $q = "DELETE FROM $table WHERE $prefix" . "$primary = :$primary";
        $parameters_values = [];
        $parameters_values[':' . $primary] = $entity->$primary;
        return $this->run_query($q, $parameters_values);
    }

    /**
     * Select query with entity objects in result set
     *
     * @param string $entity                entity name (without the _entity suffix)
     * @param string $query                 query
     * @param null   $parameters            parameters array
     * @param bool   $entity_name_as_prefix use entity name (without the _entity suffix) as field name prefix
     *
     * @return Query
     */
    public function select_entity($entity, $query, $parameters = null, $entity_name_as_prefix = true)
    {
        $q = $this->run_query($query, $parameters);
        if ($q->success)
        {
            $items = [];
            $entity .= '_entity';
            $entity = strtolower($entity);
            foreach ($q->result_set as $result_item)
            {
                /** @var Entity $item */
                $item = new $entity();
                $entity_fields = array_keys($item->get_fields());

                foreach ($result_item as $field => $value)
                {
                    if ($entity_name_as_prefix)
                    {
                        $field = str_replace($item->get_name() . '_', '', $field);
                    }
                    if (array_search($field, $entity_fields) !== false)
                    {
                        $item->$field = $value;
                    }
                }
                $items[] = $item;
            }
            $q->result_set = $items;
        }
        return $q;
    }
}