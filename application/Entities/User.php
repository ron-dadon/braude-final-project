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
 * Class User
 *
 * User entity.
 *
 * @package Application\Entities
 */
class User extends Entity
{

    /**
     * User ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * User e-mail address.
     *
     * @var string
     */
    public $email;

    /**
     * User password.
     *
     * @var string
     */
    public $password;

    /**
     * User unique token.
     *
     * @var string
     */
    public $token;

    /**
     * User first name.
     *
     * @var string
     */
    public $firstName;

    /**
     * User last name.
     *
     * @var string
     */
    public $lastName;

    /**
     * Is user an admin.
     *
     * @var int|bool
     */
    public $admin;

    /**
     * User last activity timestamp.
     *
     * @var string
     */
    public $lastActive;

    /**
     * Is user deleted.
     *
     * @var int|bool
     */
    public $delete;

    /**
     * Initialize user entity information.
     */
    function __construct()
    {
        $this->_table = "users";
        $this->_prefix = "user_";
        $this->_primary = "id";
        $this->delete = 0;
        $this->admin = 0;
        $this->token = '';
        $this->lastActive = '0000-00-00 00:00:00';
    }

    /**
     * Validate user.
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
        if (!$this->isString($this->firstName, 1, 20))
        {
            $valid = false;
            $this->setError('firstName', "First name must be 1 to 20 characters in length");
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
        if (!$this->isPattern($this->password, '/^.{6,20}$/'))
        {
            $valid = false;
            $this->setError('password', "Password must be 6 to 20 characters in length");
        }
        if (!$this->isBoolean($this->admin))
        {
            $valid = false;
            $this->setError('admin', "Administrator must be set to Yes or No");
        }
        return $valid;
    }

}