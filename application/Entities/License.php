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
 * Class License
 *
 * License entity.
 *
 * @package Application\Entities
 */
class License extends Entity
{

    /**
     * License ID.
     *
     * @var string|int|null
     */
    public $id;

    /**
     * License serial.
     *
     * @var string
     */
    public $serial;

    /**
     * License PC-ID.
     *
     * @var string|null
     */
    public $pcid;

    /**
     * License creation date.
     *
     * @var string
     */
    public $creationDate;

    /**
     * License hash.
     *
     * @var string|null
     */
    public $hash;

    /**
     * License expiration date.
     *
     * @var string
     */
    public $expire;

    /**
     * License type.
     *
     * @var LicenseType
     */
    public $type;

    /**
     * License product.
     *
     * @var Product
     */
    public $product;

    /**
     * License client.
     *
     * @var Client
     */
    public $client;

    /**
     * License related invoice if one exists.
     *
     * @var Invoice|int|null
     */
    public $invoice;

    /**
     * Is license deleted.
     *
     * @var int|bool
     */
    public $delete;

    /**
     * Initialize license entity information.
     */
    function __construct()
    {
        $this->_table = "licenses";
        $this->_prefix = "license_";
        $this->_primary = "id";
        $this->creationDate = date('Y-m-d');
        $this->expire = date('Y-m-d');
        $this->delete = 0;
        $this->serial = md5(bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)));
    }

    /**
     * Generate license hash string.
     *
     * @return null|string
     */
    public function generateLicenseHash()
    {
        $validTo = $this->timeStampToDate($this->expire);
        $trial = 0;
        if ($this->type instanceof LicenseType) {
            $trial = $this->type->name === 'Trial' ? '1' : '0';
        } else {
            if ($this->type == 1) $trial = 1;
        }
        $toHash = $this->serial . $this->product->name . $this->client->name . $trial . $validTo . ($trial ? '' : $this->pcid);
        $this->hash = hash('sha512', $toHash);
        return $this->hash;
    }

    /**
     * Get license file XML content.
     *
     * @return string
     */
    public function toFile()
    {
        $line = '<?xml version="1.0" encoding="UTF-8"?><license>';
        $line .= '<serial>' . $this->serial . '</serial>';
        $line .= '<valid>' . $this->timeStampToDate($this->expire) . '</valid>';
        $line .= '<client>' . $this->client->name . '</client>';
        $line .= '<pcid>' . ($this->type->name === 'Trial' ? '' : $this->pcid) . '</pcid>' . PHP_EOL;
        $line .= '<app>' . $this->product->name . '</app>';
        $line .= '<trial>' . ($this->type->name === 'Trial' ? '1' : '0') . '</trial>';
        $line .= '<hash>' . $this->generateLicenseHash() . '</hash></license>';
        return $line;
    }

    /**
     * Convert time stamp string to dd/mm/yyyy string.
     *
     * @param string $ts Timestamp.
     *
     * @return string
     */
    private function timeStampToDate($ts)
    {
        return substr($ts, 8, 2) . '/' . substr($ts, 5, 2) . '/' . substr($ts, 0, 4);
    }

    /**
     * Validate license.
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
        if (!$this->isDate($this->creationDate) && !$this->isDateTime($this->creationDate))
        {
            $valid = false;
            $this->setError('creationDate', "Creation date must be a valid date");
        }
        if (!$this->isDate($this->expire) && !$this->isDateTime($this->expire))
        {
            $valid = false;
            $this->setError('expire', "Expire date must be a valid date");
        }
        if (!$this->isInteger($this->client, 1) && !($this->client instanceof Client))
        {
            $valid = false;
            $this->setError('client', "Client is invalid");
        }
        if (!$this->isInteger($this->type, 1) && !($this->type instanceof LicenseType))
        {
            $valid = false;
            $this->setError('type', "License type is invalid");
        }
        if (!$this->isInteger($this->product, 1) && !($this->product instanceof Product))
        {
            $valid = false;
            $this->setError('product', "Product is invalid");
        }
        if (!$this->isInteger($this->invoice, 0) && !($this->invoice instanceof Invoice))
        {
            $valid = false;
            $this->setError('invoice', "Invoice is invalid");
        }
        if (!$this->isPattern($this->serial, '/^[a-f0-9]{32}$/'))
        {
            $valid = false;
            $this->setError('serial', "Serial is invalid");
        }
        return $valid;
    }

} 