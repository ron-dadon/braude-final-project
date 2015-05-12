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

    public $type;
    public $serial;
    public $creationDate;
    public $validUntil;

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