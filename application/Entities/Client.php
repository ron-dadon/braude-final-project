<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:42
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Client extends Entity {
    public $id;
    public $name;
    public $address;
    public $phone;
    public $email;
    public $website;
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
        if (!$this->isString($this->name, 1, 20))
        {
            $valid = false;
            $this->_errors['name'] = "Name must be at least 1 character and up to 20";
        }
        if (!$this->isString($this->address, 1,100))
        {
            $valid = false;
            $this->_errors['address'] = "Address must be at least 1 character and up to 100";
        }
        if (!$this->isEmail($this->email))
        {
            $valid = false;
            $this->_errors['email'] = "Email is not in a valid format";
        }
        if (!$this->isPattern($this->phone,'/^[0-9]{9,10}|[0-9]{2,3}\-[0-9]{7}$/'))
        {
            $valid = false;
            $this->_errors['phone'] = "Phone must be 9 or 10 digits long and can allow a -";
        }
        if (!$this->isURL($this->website))
        {
            $valid = false;
            $this->_errors['website'] = "Website is not in a valid format";
        }

        return $valid;
    }

} 