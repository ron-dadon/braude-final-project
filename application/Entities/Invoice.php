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
    /**
     * Implement validation rules.
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        // TODO: Implement isValid() method.
    }

} 