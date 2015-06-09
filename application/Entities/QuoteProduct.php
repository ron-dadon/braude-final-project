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

    /**
     * Initialize product entity information.
     */
    function __construct()
    {
        $this->_table = "quote_products";
        $this->_prefix = "quote_product_";
    }

    public function isValid()
    {
        $valid = parent::isValid();

    }

} 