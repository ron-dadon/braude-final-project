<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:41
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Quote extends Entity {

    public $id;
    public $note;
    public $date;
    public $expire;
    public $taxRate;
    /** @var  QuoteStatus */
    public $status;
    /** @var  Client */
    public $client;
    /** @var Product[] */
    public $products = [];
    public $delete;

    /**
     * Initialize product entity information.
     */
    function __construct()
    {
        $this->_table = "quotes";
        $this->_prefix = "quote_";
        $this->_primary = "id";
        $this->delete = 0;
        $this->date = date('Y-m-d');
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
        if (!$this->isDate($this->date))
        {
            $valid = false;
            $this->setError('date', "Date must be a valid date");
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
        if (!$this->isInteger($this->status, 1) && !($this->status instanceof QuoteStatus))
        {
            $valid = false;
            $this->setError('status', "License type is invalid");
        }
        if (!$this->isFloat($this->taxRate, 0) || !$this->isPattern($this->taxRate, '/^[0-9]{1,2}(\.[0-9]{1,2})?$/'))
        {
            $valid = false;
            $this->setError('taxRate', "Tax rate must be a positive decimal number");
        }
        if (is_array($this->products) && count($this->products))
        {
            foreach ($this->products as $product)
            {
                if (!$this->isInteger($product, 1) && !($product instanceof Product))
                {
                    $valid = false;
                    $this->setError('products', "Products list is invalid");
                }
            }
        }
        if (is_array($this->contacts) && count($this->contacts))
        {
            foreach ($this->contacts as $contact)
            {
                if (!$this->isInteger($contact, 1) && !($contact instanceof Contact))
                {
                    $valid = false;
                    $this->setError('contacts', "Contacts list is invalid");
                }
            }
        }
        return $valid;
    }

} 