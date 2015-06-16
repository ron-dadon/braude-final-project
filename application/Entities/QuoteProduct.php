<?php

namespace Application\Entities;

use Trident\ORM\Entity;

class QuoteProduct extends Entity
{

    public $price;
    public $quantity;
    public $comment;
    /** @var  Product */
    public $product;
    public $basePrice;
    public $discount;
    public $finalPrice;

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
        if (!$this->isFloat($this->price, 0))
        {
            $valid = false;
            $this->setError('Price', "Price must be in a valid format");
        }
        if (!$this->isInteger($this->quantity, 1))
        {
            $valid = false;
            $this->setError('quantity', "Quantity is invalid");
        }
        if (!$this->isString($this->comment, 0,2000 ))
        {
            $valid = false;
            $this->setError('comment', "Comment length can't exceed 2000 characters");
        }
        return $valid;
    }

} 