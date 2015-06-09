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
        $this->type = "software";
        $this->basePrice = 0;
        $this->version = "1.00";
        $this->length = 0;
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
            if (!$this->isInteger($this->license, 1))
            {
                $valid = false;
                $this->setError('license', "License type is invalid");
            }
        }
        return $valid;
    }
}