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
    public $creationDate;
    public $validTo;
    public $status;
    public $delete;

    function __construct()
    {
        $this->_table = "quotes";
        $this->_prefix = "quote_";
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
        if (!$this->isDate($this->validTo))
        {
            $valid = false;
            $this->_errors['validTo'] = "Creation Date must be a valid date format";
        }
        if (!$this->isString($this->status, 1, 30))
        {
            $valid = false;
            $this->_errors['status'] = "status must be at least 1 character and up to 20";
        }
        if (!$this->isBoolean($this->delete))
        {
            $valid = false;
            $this->_errors['delete'] = "Delete must be 1 or 0 only";
        }
        return $valid;

    }

} 