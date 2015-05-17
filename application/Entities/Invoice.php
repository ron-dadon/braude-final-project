<?php

namespace application\Entities;

use Trident\ORM\Entity;

class Invoice extends Entity
{

    public $id;
    public $note;
    public $date;
    public $receipt;
    public $tax;
    public $taxRate;
    /** @var Quote */
    public $quote;
    /** @var Client */
    public $client;
    public $delete;

    /**
     * Initialize invoice entity information.
     */
    function __construct()
    {
        $this->_table = "invoices";
        $this->_prefix = "invoice_";
        $this->_primary = "id";
        $this->date = date('Y-m-d');
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
        if (!$this->isString($this->note, 0, 65535))
        {
            $valid = false;
            $this->setError('note', "Note length can't exceed 65535 characters");
        }
        if (!$this->isDate($this->date))
        {
            $valid = false;
            $this->setError('date', "Creation date must be a valid date");
        }
        if (!$this->isString($this->receipt, 0, 50))
        {
            $valid = false;
            $this->setError('receipt', "Receipt length can't exceed 50 characters");
        }
        if (!$this->isString($this->tax, 0, 50))
        {
            $valid = false;
            $this->setError('tax', "Tax invoice length can't exceed 50 characters");
        }
        if (!$this->isFloat($this->taxRate, 0) || !$this->isPattern($this->taxRate, '/^[0-9]{1,2}(\.[0-9]{1,2})?$/'))
        {
            $valid = false;
            $this->setError('taxRate', "Tax rate must be a positive decimal number");
        }
        return $valid;
    }

} 