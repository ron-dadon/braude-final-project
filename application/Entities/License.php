<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:40
 */

namespace application\Entities;


use Trident\ORM\Entity;

class License extends Entity {

    public $id;
    public $type;
    public $serial;
    public $creationDate;
    public $validUntil;

    function __construct()
    {
        $this->_table = "licenses";
        $this->_prefix = "license_";
        $this->_primary = "id";
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
            $this->_errors['id'] = "Invalid id";
        }
        if (!$this->isDate($this->creationDate))
        {
            $valid = false;
            $this->_errors['creationDate'] = "Creation Date must be a valid date format";
        }
        if (!$this->isDate($this->validUntil))
        {
            $valid = false;
            $this->_errors['validUntil'] = "valid Until must be a valid date format";
        }

        /** add serial check */

        return $valid;

    }

} 