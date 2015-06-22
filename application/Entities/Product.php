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
 * Class Product
 *
 * Product entity.
 *
 * @package Application\Entities
 */
class Product extends Entity
{

    /**
     * Product ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * Product manufacturer.
     * Possible values: iacs, caseware.
     *
     * @var string
     */
    public $manufactor;

    /**
     * Product name.
     *
     * @var string
     */
    public $name;

    /**
     * Product description.
     *
     * @var string
     */
    public $description;

    /**
     * Product base price.
     *
     * @var int
     */
    public $basePrice;

    /**
     * Product currency.
     * Possible values: usd, nis.
     *
     * @var string
     */
    public $coin;

    /**
     * Product type.
     * Possible values: software, training.
     *
     * @var string
     */
    public $type;

    /**
     * Is product deleted.
     *
     * @var int|bool
     */
    public $delete;

    /* Software */

    /**
     * Software version.
     *
     * @var string
     */
    public $version;

    /**
     * Software license type.
     *
     * @var LicenseType
     */
    public $license;

    /* Training */

    /**
     * Training length in hours.
     *
     * @var int
     */
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
        $this->manufactor = 'iacs';
    }

    /**
     * Validate product.
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
        if (!$this->isInList($this->manufactor, ['iacs', 'caseware']))
        {
            $valid = false;
            $this->setError('manufactor', "Product manufacturer can be only IACS or CaseWare");
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