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
 * Class QuoteProduct
 *
 * Quote product entity.
 *
 * @package Application\Entities
 */
class QuoteProduct extends Entity
{

    /**
     * Quantity of the product.
     *
     * @var int
     */
    public $quantity;

    /**
     * Related product.
     *
     * @var  Product
     */
    public $product;

    /**
     * Initialize quote-product entity information.
     */
    function __construct()
    {
        $this->_table = "quote_products";
        $this->_prefix = "quote_product_";
    }

    /**
     * Validate quote product.
     *
     * @return bool
     */
    public function isValid()
    {
        $valid = true;
        if (!$this->isInteger($this->quantity, 1))
        {
            $valid = false;
            $this->setError('quantity', "Quantity is invalid");
        }
        return $valid;
    }

} 