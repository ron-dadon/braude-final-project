<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:43
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Contact extends  Entity {

    public $id;
    public $firstName;
    public $lastName;
    public $phone;
    public $fax;
    public $email;
    public $position;
    /**
     * Implement validation rules.
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        // TODO: Implement isValid() method.
    }

} 