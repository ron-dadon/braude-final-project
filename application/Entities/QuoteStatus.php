<?php

namespace application\Entities;

use Trident\ORM\Entity;

class QuoteStatus extends Entity
{

    public $id;
    public $name;
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
     * Implement validation rules.
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