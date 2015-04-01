<?php

/**
 * Class Model
 */
class Model
{

    /**
     * Configuration object reference
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Database object reference
     *
     * @var Database
     */
    protected $_database;

    /**
     * Request object reference
     *
     * @var Request
     */
    protected $_request;

    /**
     * Model constructor
     *
     * Build model and set objects references
     *
     * @param Configuration $configuration configuration reference
     * @param Request       $request       request reference
     * @param Database      $database      database reference
     */
    function __construct($configuration, $request, $database)
    {
        $this->_configuration = $configuration;
        $this->_request = $request;
        $this->_database = $database;
    }

    /**
     * Load entity
     *
     * @param string $entity entity name (without the _entity suffix)
     *
     * @return Entity
     */
    public function load_entity($entity)
    {
        $entity .= '_entity';
        $entity = strtolower($entity);
        return new $entity();
    }
}