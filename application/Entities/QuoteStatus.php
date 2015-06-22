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
 * Class QuoteStatus
 *
 * Quote status entity.
 *
 * @package Application\Entities
 */
class QuoteStatus extends Entity
{

    /**
     * Quote status ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * Quote status name.
     *
     * @var string
     */
    public $name;

    /**
     * Quote status is deleted.
     *
     * @var int|bool
     */
    public $delete;

    /**
     * Initialize license type entity information.
     */
    function __construct()
    {
        $this->_table = "quote_statuses";
        $this->_prefix = "quote_status_";
        $this->_primary = "id";
        $this->delete = 0;
    }

    /**
     * Validate quote status.
     *
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        $valid = true;
        if (!$this->isInteger($this->id, 1) && $this->id !== null)
        {
            $valid = false;
            $this->setError('id', "ID is invalid");
        }
        if (!$this->isString($this->name, 1, 100))
        {
            $valid = false;
            $this->setError('name', "Name must be 1 to 100 characters in length");
        }
        return $valid;
    }

} 