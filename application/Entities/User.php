<?php

namespace Application\Entities;

use Trident\ORM\Entity;

class User extends Entity
{

    public $id;
    public $email;
    public $password;
    public $token;
    public $firstName;
    public $lastName;
    public $admin;
    public $lastActive;
    public $delete;

    /**
     * Initialize user entity information.
     */
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
            $this->setError('id', "ID is invalid");
        }
        if (!$this->isString($this->firstName, 1, 20))
        {
            $valid = false;
            $this->setError('firstName', "First name must be 1 to 100 characters in length");
        }
        if (!$this->isString($this->lastName, 0, 20))
        {
            $valid = false;
            $this->setError('lastName', "Last name must not exceed 20 characters in length");
        }
        if (!$this->isEmail($this->email))
        {
            $valid = false;
            $this->setError('email', "E-mail is invalid e-mail address");
        }
        if (!$this->isPattern($this->password, '/^[.]{6,20}$/'))
        {
            $valid = false;
            $this->setError('password', "Password must be 6 to 20 characters in length");
        }
        if (!$this->isBoolean($this->admin))
        {
            $valid = false;
            $this->_errors['admin'] = "Administrator must be set to Yes or No";
        }
        return $valid;
    }

}