<?php

namespace application\Entities;

use Trident\ORM\Entity;

class Contact extends Entity
{

    public $id;
    public $firstName;
    public $lastName;
    public $phone;
    public $fax;
    public $email;
    public $position;
    /** @var Client */
    public $client;
    public $delete;

    /**
     * Initialize contact entity information.
     */
    function __construct()
    {
        $this->_table = "contacts";
        $this->_prefix = "contact_";
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
        if (!$this->isEmail($this->email) && !$this->email !== "")
        {
            $valid = false;
            $this->setError('email', "E-mail is invalid e-mail address");
        }
        if (!$this->isPattern($this->phone, '/^[0-9]{9,10}|[0-9]{2,3}\-[0-9]{7}$/') && $this->phone !== "")
        {
            $valid = false;
            $this->setError('phone', "Phone is invalid. Phone can contain only digits with a single/no dash");
        }
        if (!$this->isPattern($this->fax, '/^[0-9]{9,10}$|^[0-9]{2,3}\-[0-9]{7}$/') && $this->fax !== "")
        {
            $valid = false;
            $this->setError('fax', "Fax is invalid. Fax can contain only digits with a single/no dash");
        }
        if (!$this->isString($this->position, 0, 100))
        {
            $valid = false;
            $this->setError('position', "Position must not exceed 100 characters in length");
        }
        if (!$this->isInteger($this->client, 1) && !($this->client instanceof Client))
        {
            $valid = false;
            $this->setError('client', "Client is invalid");
        }
        return $valid;
    }
}