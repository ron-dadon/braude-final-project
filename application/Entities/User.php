<?php

namespace Application\Entities;

use Trident\ORM\Entity;

class User extends Entity
{

    public $id;
    public $password;
    public $salt;
    public $token;
    public $firstName;
    public $lastName;
    public $email;
    public $delete;

    function __construct()
    {
        $this->_table = "users";
        $this->_prefix = "user_";
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
        if (!$this->isString($this->firstName, 1, 20))
        {
            $valid = false;
            $this->_errors['firstName'] = "First name must be at least 1 character and up to 20";
        }
        if (!$this->isString($this->lastName, 1, 20))
        {
            $valid = false;
            $this->_errors['lastName'] = "Last name must be at least 1 character and up to 20";
        }
        if (!$this->isEmail($this->email))
        {
            $valid = false;
            $this->_errors['email'] = "Email is not in a valid format";
        }
        if (!$this->isPattern($this->password, '/^[a-zA-Z0-9\@\!\#\$\%\^\*]{6,12}$/'))
        {
            $valid = false;
            $this->_errors['password'] = "password is not in a valid format";
        }
        if (!$this->isBoolean($this->delete))
        {
            $valid = false;
            $this->_errors['delete'] = "Delete must be 1 or 0 only";
        }
        return $valid;
    }

}