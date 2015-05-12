<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:41
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Invoice extends Entity {

    public $id;
    public $note;
    public $creationDate;
    public $receipt;
    public $taxInvoice;

    function __construct()
    {
        $this->_table = "invoices";
        $this->_prefix = "invoice_";
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
        if (!$this->isString($this->note, 0, 65535))
        {
            $valid = false;
            $this->_errors['note'] = "Note must be up to 65535 characters";
        }
        if (!$this->isDate($this->creationDate))
        {
            $valid = false;
            $this->_errors['creationDate'] = "Creation Date must be a valid date format";
        }
        if (!$this->isString($this->receipt, 0, 30))
        {
            $valid = false;
            $this->_errors['receipt'] = "Receipt must be up to 30 characters";
        }
        if (!$this->isString($this->taxInvoice, 0, 30))
        {
            $valid = false;
            $this->_errors['taxInvoice'] = "Tax Invoice must be up to 30 characters";
        }


        return $valid;
    }

} 