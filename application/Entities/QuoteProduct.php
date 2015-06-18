<?php

namespace Application\Entities;

use Trident\ORM\Entity;

class QuoteProduct extends Entity
{

    public $quantity;
    /** @var  Product */
    public $product;

    /**
     * Initialize quote-product entity information.
     */
    function __construct()
    {
        $this->_table = "quote_products";
        $this->_prefix = "quote_product_";
    }

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