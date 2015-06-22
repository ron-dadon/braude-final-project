<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Entities;

use Trident\ORM\Entity;

/**
 * Class LogEntry
 *
 * Log entry entity.
 *
 * @package Application\Entities
 */
class LogEntry extends Entity
{

    /**
     * Log entry ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * Log entry timestamp.
     *
     * @var string
     */
    public $ts;

    /**
     * Log entry related user.
     *
     * @var  User|null
     */
    public $user;

    /**
     * Log entry IP address.
     *
     * @var string
     */
    public $ip;

    /**
     * Log entry browser.
     *
     * @var string
     */
    public $browser;

    /**
     * Log entry platform.
     *
     * @var string
     */
    public $platform;

    /**
     * Log entry text.
     *
     * @var string
     */
    public $entry;

    /**
     * Log entry level.
     * Level are "success", "danger", "warning" and "info".
     *
     * @var string
     */
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
     * Validate log entry.
     *
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