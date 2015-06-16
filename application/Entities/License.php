<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:40
 */

namespace application\Entities;


use Trident\ORM\Entity;

class License extends Entity
{

    public $id;
    public $serial;
    public $creationDate;
    public $expire;
    /** @var LicenseType */
    public $type;
    /** @var Product */
    public $product;
    /** @var Client */
    public $client;
    /** @var Invoice */
    public $invoice;
    public $delete;

    /**
     * Initialize license entity information.
     */
    function __construct()
    {
        $this->_table = "licenses";
        $this->_prefix = "license_";
        $this->_primary = "id";
        $this->creationDate = date('Y-m-d');
        $this->expire = date('Y-m-d');
        $this->delete = 0;
        $this->serial = md5(bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)));
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
        if (!$this->isDate($this->creationDate))
        {
            $valid = false;
            $this->setError('creationDate', "Creation date must be a valid date");
        }
        if (!$this->isDate($this->expire))
        {
            $valid = false;
            $this->setError('expire', "Expire date must be a valid date");
        }
        if (!$this->isInteger($this->client, 1) && !($this->client instanceof Client))
        {
            $valid = false;
            $this->setError('client', "Client is invalid");
        }
        if (!$this->isInteger($this->type, 1) && !($this->type instanceof LicenseType))
        {
            $valid = false;
            $this->setError('type', "License type is invalid");
        }
        if (!$this->isInteger($this->product, 1) && !($this->product instanceof Product))
        {
            $valid = false;
            $this->setError('product', "Product is invalid");
        }
        if (!$this->isInteger($this->invoice, 1) && !($this->invoice instanceof Invoice))
        {
            $valid = false;
            $this->setError('invoice', "Invoice is invalid");
        }
        if (!$this->isPattern($this->serial, '/^[a-f0-9]{32}$/'))
        {
            $valid = false;
            $this->setError('serial', "Serial is invalid");
        }
        return $valid;
    }

} 