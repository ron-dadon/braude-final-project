<?php

namespace application\Entities;

use Trident\ORM\Entity;

class Product extends Entity
{
    public $id;
    public $name;
    public $description;
    public $basePrice;
    public $coin;
    public $type;
    public $delete;
    /* Software */
    public $version;
    /** @var LicenseType */
    public $license;
    /* Training */
    public $length;
    /*add ons*/
    public $discount;
    public $date;
    public $finalPrice;


    /**
     * Initialize product entity information.
     */
    function __construct()
    {
        $this->_table = "products";
        $this->_prefix = "product_";
        $this->_primary = "id";
        $this->delete = 0;
        $this->coin = "nis";
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
        if (!$this->isString($this->name, 1, 200))
        {
            $valid = false;
            $this->setError('name', "Name must be 1 to 50 characters in length");
        }
        if (!$this->isString($this->description, 0, 65535))
        {
            $valid = false;
            $this->setError('description', "Description length can't exceed 65535 characters");
        }
        if (!$this->isFloat($this->basePrice, 0))
        {
            $valid = false;
            $this->setError('basePrice', "Base Price must be in a valid format");
        }
        if (!$this->isInList($this->coin, ['usd', 'nis']))
        {
            $valid = false;
            $this->setError('coin', "Coin type can be only USD or NIS");
        }
        if (!$this->isInList($this->type, ['software', 'training']))
        {
            $valid = false;
            $this->setError('type', "Product type can be only Software or Training");
        }
        if ((!$this->isDate($this->date))&&($this->date!== null))
        {
            $valid = false;
            $this->setError('date', "Date must be a valid date");
        }
        if ($this->type === 'training')
        {
            if (!$this->isInteger($this->length, 0))
            {
                $valid = false;
                $this->setError('length', "Training length must be a positive number");
            }
        }
        if ($this->type === 'software')
        {
            if (!$this->isPattern($this->version, '/^[0-9a-zA-Z\.\s]{0,20}$/'))
            {
                $valid = false;
                $this->setError('version', "Version can contain only letters, numbers, dashes and periods.");
            }
            if (!$this->isInteger($this->license, 1) && !($this->license instanceof LicenseType))
            {
                $valid = false;
                $this->setError('license', "License type is invalid");
            }
        }
        if (!$this->isFloat($this->discount, 0,100))
        {
            $valid = false;
            $this->setError('discount', "Discount must be a positive decimal number up to 100");
        }
        if (!$this->isFloat($this->finalPrice, 0))
        {
            $valid = false;
            $this->setError('finalPrice', "Final Price must be a positive decimal number");
        }
        return $valid;
    }
}