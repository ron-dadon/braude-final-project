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
 * Class Client
 *
 * Client entity class.
 *
 * @package Application\Entities
 */
class Client extends Entity
{

    /**
     * Client ID.
     *
     * @var int|string|null
     */
    public $id;

    /**
     * Client name.
     *
     * @var string
     */
    public $name;

    /**
     * Client address.
     *
     * @var string
     */
    public $address;

    /**
     * Client phone number.
     *
     * @var string
     */
    public $phone;

    /**
     * Client e-mail.
     *
     * @var string
     */
    public $email;

    /**
     * Client web site url.
     *
     * @var string
     */
    public $webSite;

    /**
     * Is client deleted.
     *
     * @var int|bool
     */
    public $delete;

    /**
     * Initialize client entity information.
     */
    function __construct()
    {
        $this->_table = "clients";
        $this->_prefix = "client_";
        $this->_primary = "id";
        $this->delete = 0;
    }

    /**
     * Validate client.
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
        if (!$this->isString($this->address, 0, 200))
        {
            $valid = false;
            $this->setError('address', "Address length can't exceed 200 characters");
        }
        if (!$this->isEmail($this->email) && $this->email !== "")
        {
            $valid = false;
            $this->setError('email', "E-mail is invalid e-mail address");
        }
        if (!$this->isPattern($this->phone, '/^[0-9]{9,10}$|^[0-9]{2,3}\-[0-9]{7}$/') && $this->phone !== "")
        {
            $valid = false;
            $this->setError('phone', "Phone is invalid. phone can contain only digits with a single/no dash");
        }
        if (!$this->isURL($this->webSite) && $this->webSite !== "" && $this->webSite !== null)
        {
            $valid = false;
            $this->setError('website', "Web site must be a valid address");
        }
        return $valid;
    }

}