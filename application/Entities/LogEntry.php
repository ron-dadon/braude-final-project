<?php

namespace application\Entities;

use Trident\ORM\Entity;

class LogEntry extends Entity
{

    public $id;
    public $ts;
    /** @var  User */
    public $user;
    public $ip;
    public $browser;
    public $platform;
    public $entry;
    public $level;

    /**
     * Initialize client entity information.
     */
    function __construct()
    {
        $this->_table = "log";
        $this->_prefix = "log_";
        $this->_primary = "id";
        $this->ts = date('Y-m-d H:i:s');
    }

    /**
     * Implement validation rules.
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        return true;
    }
} 