<?php

/**
 * Class Post
 */
class Post extends Global_Array
{

    /**
     * Post constructor
     *
     * Build sanitized post data
     */
    function __construct()
    {
        $this->_data = $this->sanitize($_POST);
    }
}