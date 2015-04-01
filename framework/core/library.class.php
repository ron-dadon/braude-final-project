<?php

/**
 * Class Library
 */
abstract class Library
{

    /**
     * Configuration object reference
     *
     * @var Configuration
     */
    protected $_configuration;

    /**
     * Request object reference
     *
     * @var Request
     */
    protected $_request;

    /**
     * Library constructor
     *
     * Build library and set objects references
     *
     * @param Configuration $configuration configuration reference
     * @param Request       $request       request reference
     */
    function __construct($configuration, $request)
    {
        $this->_configuration = $configuration;
        $this->_request = $request;
    }
}