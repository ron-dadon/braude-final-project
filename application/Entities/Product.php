<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:39
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Product extends Entity {
    public $id;
    public $name;
    public $description;
    public $basePrice;
    public $type;
    /**software*/
    public $version;
    public $license;
    /**training*/
    public $length;

    function __construct()
    {
        $this->_table = "products";
        $this->_prefix = "product_";
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
        if (!$this->isString($this->name, 1, 50))
        {
            $valid = false;
            $this->_errors['name'] = "Name must be at least 1 character and up to 50";
        }
        if (!$this->isString($this->description, 0, 65535))
        {
            $valid = false;
            $this->_errors['description'] = "Description must be up to 65535";
        }
        if (!$this->isFloat($this->basePrice,0))
        {
            $valid = false;
            $this->_errors['basePrice'] = "Base Price must be in a valid format ";
        }
        if (!$this->isInteger($this->length,0))
        {
            $valid = false;
            $this->_errors['length'] = "length must be in a valid format ";
        }
        if (!$this->isPattern($this->version,'/^[0-9a-zA-Z\.\s]{,20}&/'))
        {
            $valid = false;
            $this->_errors['version'] = "version must be in a valid format ";
        }

        return $valid;
    }


} 