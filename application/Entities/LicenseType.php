<?php

namespace application\Entities;

use Trident\ORM\Entity;

class LicenseType extends Entity
{

    public $id;
    public $name;
    public $description;
    public $delete;

    /**
     * Initialize license type entity information.
     */
    function __construct()
    {
        $this->_table = "license_types";
        $this->_prefix = "license_type_";
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
        if (!$this->isString($this->description, 0, 1000))
        {
            $valid = false;
            $this->setError('description', "Description length can't exceed 1000 characters");
        }
        return $valid;
    }

} 