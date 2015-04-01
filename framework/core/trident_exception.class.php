<?php

/**
 * Class TridentException
 */
class Trident_Exception extends Exception
{

    /**
     * Trident exception constructor
     *
     * Build exception object with a given message
     *
     * @param string $message exception message
     */
    function __construct($message)
    {
        parent::__construct('Trident::' . $message);
    }
}