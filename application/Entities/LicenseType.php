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
 * Class LicenseType
 *
 * License type entity.
 *
 * @package Application\Entities
 */
class LicenseType extends Entity
{

    /**
     * License type ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * License type display name.
     *
     * @var string
     */
    public $name;

    /**
     * License type description.
     * @var
     */
    public $description;

    /**
     * Is license type deleted.
     *
     * @var int|bool
     */
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
     * Validate license type.
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
        if (!$this->isString($this->description, 0, 1000))
        {
            $valid = false;
            $this->setError('description', "Description length can't exceed 1000 characters");
        }
        return $valid;
    }

    /**
     * Get the id of the license type.
     *
     * @return string
     */
    function __toString()
    {
        return $this->id;
    }

} 