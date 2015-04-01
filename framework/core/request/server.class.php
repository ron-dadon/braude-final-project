<?php

/**
 * Class Server
 */
class Server extends Global_Array
{

    /**
     * Server constructor
     *
     * Build sanitized server data
     */
    function __construct()
    {
        $this->_data = $this->sanitize($_SERVER);
    }
}