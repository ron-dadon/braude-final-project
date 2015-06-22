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
 * Class Quote
 *
 * Quote entity.
 *
 * @package Application\Entities
 */
class Quote extends Entity
{

    /**
     * Quote ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * Quote note.
     *
     * @var string
     */
    public $note;

    /**
     * Quote creation date.
     *
     * @var string
     */
    public $date;

    /**
     * Quote expiration date.
     *
     * @var string
     */
    public $expire;

    /**
     * Quote tax rate.
     *
     * @var float
     */
    public $taxRate;

    /**
     * Quote USD to NIS ratio.
     *
     * @var float
     */
    public $usdRate;

    /**
     * Quote discount.
     *
     * @var float
     */
    public $discount;

    /**
     * Quote status.
     *
     * @var  QuoteStatus
     */
    public $status;

    /**
     * Quote client.
     *
     * @var  Client
     */
    public $client;

    /**
     * Quote products list.
     *
     * @var QuoteProduct[]
     */
    public $products;

    /**
     * Is quote deleted.
     *
     * @var int|bool
     */
    public $delete;

    /**
     * Initialize product entity information.
     */
    function __construct()
    {
        $this->_table = "quotes";
        $this->_prefix = "quote_";
        $this->_primary = "id";
        $this->delete = 0;
        $this->date = date('Y-m-d');
        $this->expire = date('Y-m-d', strtotime('+2 week'));
        $this->status = 1;
    }

    /**
     * Get the tax amount.
     *
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->getSubTotal() * ($this->taxRate / 100);
    }

    /**
     * Get the sub total with discount, without tax.
     *
     * @return float
     */
    public function getSubTotal()
    {
        $total = 0;
        foreach ($this->products as $p) {
            $total += $p->product->basePrice * ($p->product->coin === 'usd' ? $this->usdRate : 1) * $p->quantity;
        }
        if ($this->discount) {
            $total *= (1 - ($this->discount / 100));
        }
        return $total;
    }

    /**
     * Get total + tax.
     *
     * @return float
     */
    public function getTotalWithTax()
    {
        return $this->getSubTotal() + $this->getTaxAmount();
    }

    /**
     * Validate quote.
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
        if (!$this->isDate($this->date))
        {
            $valid = false;
            $this->setError('date', "Date must be a valid date");
        }
        if (!$this->isDate($this->expire))
        {
            $valid = false;
            $this->setError('expire', "Expire date must be a valid date");
        }
        if (!$this->isInteger($this->client, 1) && !($this->client instanceof Client))
        {
            $valid = false;
            $this->setError('client', "Client is invalid");
        }
        if (!$this->isInteger($this->status, 1) && !($this->status instanceof QuoteStatus))
        {
            $valid = false;
            $this->setError('status', "Status is invalid");
        }
        if (!$this->isFloat($this->taxRate, 0) || !$this->isPattern($this->taxRate, '/^[0-9]{1,2}(\.[0-9]{1,2})?$/'))
        {
            $valid = false;
            $this->setError('taxRate', "Tax rate must be a positive decimal number");
        }
        if (is_array($this->products) && count($this->products))
        {
            foreach ($this->products as $product)
            {
                if (!$this->isInteger($product, 1) && !($product instanceof Product))
                {
                    $valid = false;
                    $this->setError('products', "Products list is invalid");
                }
            }
        }
        return $valid;
    }

} 