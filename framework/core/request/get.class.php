<?php

/**
 * Class Get
 */
class Get extends Global_Array
{

    /**
     * Get constructor
     *
     * Build sanitized get data
     */
    function __construct()
    {
        $this->_data = $this->sanitize($_GET);
    }
}