<?php


namespace Trident\Exceptions;

use Exception;

class TridentException extends \Exception
{

    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        error_log("$message");
    }
}