<?php

namespace Application\Entities;

use Trident\ORM\Entity;

class User extends Entity
{

    public $id;
    public $firstName;

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
        if (!$this->isString($this->firstName, 1, 20))
        {
            $valid = false;
            $this->_errors['firstName'] = "First name must be a";
        }
    }

}