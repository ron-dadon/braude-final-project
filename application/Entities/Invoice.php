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
 * Class Invoice
 *
 * Invoice entity class.
 *
 * @package Application\Entities
 */
class Invoice extends Entity
{

    /**
     * Invoice ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * Invoice note.
     *
     * @var string
     */
    public $note;

    /**
     * Invoice date.
     *
     * @var string
     */
    public $date;

    /**
     * Invoice receipt.
     *
     * @var string
     */
    public $receipt;

    /**
     * Invoice tax invoice.
     *
     * @var string
     */
    public $tax;

    /**
     * Invoice client.
     *
     * @var  Client
     */
    public $client;

    /**
     * Invoice related quote.
     *
     * @var Quote
     */
    public $quote;

    /**
     * Is invoice deleted.
     *
     * @var int|bool
     */
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
     * Validate invoice.
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
        if (!$this->isString($this->note, 0, 65535))
        {
            $valid = false;
            $this->setError('note', "Note length can't exceed 65535 characters");
        }
        if (!$this->isDate($this->date) && !$this->isDateTime($this->date))
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
        return $valid;
    }

} 