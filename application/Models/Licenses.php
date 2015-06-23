<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Application\Entities\Invoice;
use Trident\MVC\AbstractModel;
use Application\Entities\License;
use Trident\Database\Result;
use Application\Entities\Product;
use Application\Entities\Client;
use Trident\Exceptions\EntityNotFoundException;

/**
 * Class Licenses
 *
 * This class provides the data-access layer to the licenses in the database.
 *
 * @package Application\Models
 */
class Licenses extends AbstractModel
{

    /**
     * Get license by it's ID.
     *
     * @param string|int $id License ID.
     *
     * @return License|null
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        /** @var License $license */
        $license = $this->getORM()->findById('License', $id, "license_delete = 0");
        $license->client = $this->getORM()->findById('Client', $license->client, 'client_delete = 0');
        $license->type = $this->getORM()->findById('LicenseType', $license->type, 'license_type_delete = 0');
        /** @var Products $products */
        $products = $this->loadModel('Products');
        $license->product = $products->getById($license->product);
        if ($license->invoice !== null) {
            $license->invoice = $this->getORM()->findById('Invoice', $license->invoice, 'invoice_delete = 0');
        }
        return $license;
    }

    /**
     * Get all licenses.
     *
     * @return License[]|null
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        /** @var License[] $licenses */
        $licenses = $this->getORM()->find('License', "license_delete = 0");
        foreach ($licenses as $key => $value) {
            $licenses[$key] = $this->getById($value->id);
        }
        return $licenses;
    }

    /**
     * Get licenses that match the search.
     *
     * @param string $term Search term (WHERE condition).
     * @param array $values Term parameters values.
     *
     * @return License[]|null
     * @throws EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search license values mush be an array");
        }
        /** @var License[] $licenses */
        $licenses = $this->getORM()->find('License',"$term AND license_delete = 0", $values);
        foreach ($licenses as $key => $value) {
            $licenses[$key] = $this->getById($value->id);
        }
        return $licenses;
    }

    /**
     * Add a new license to the system.
     *
     * @param License $license
     *
     * @return Result
     */
    public function add($license)
    {
        return $this->getORM()->save($license);
    }

    /**
     * Delete a license from the system.
     *
     * @param License $license
     *
     * @return Result
     */
    public function delete($license)
    {
        $license->delete = 1;
        return $this->getORM()->save($license);

    }

    /**
     * Add a new license from request file.
     *
     * @param string $file Request file path.
     * @param string $serial Serial number.
     * @param Product $product Product instance.
     * @param Client $client Client instance.
     * @param Invoice|null $invoice Invoice instance.
     * @param string $expire Expiration date.
     *
     * @return Result|string
     * @throws EntityNotFoundException
     */
    public function fromRequest($file, $serial, $product, $client, $expire, $invoice = null)
    {
        $file = simplexml_load_file($file);
        if (count(get_object_vars($file)) == 2 &&
            array_key_exists('app', get_object_vars($file)) !== false &&
            array_key_exists('pcid', get_object_vars($file)) !== false) {
            $file = get_object_vars($file);
            if ($file['app'] != $product->name) return "Request file product doesn't match";
            $license = new License();
            $license->pcid = $file['pcid'];
            $license->serial = $serial;
            $license->expire = $expire;
            $license->product = $product;
            $license->client = $client;
            $license->invoice = $invoice instanceof Invoice ? $invoice->id : null;
            $license->type = $product->license->id;
            $license->generateLicenseHash();
            $license->product = $product->id;
            $license->client = $client->id;
            return $this->add($license);
        }
        return "Invalid request file";
    }

    /**
     * Get all the expiring licenses of a given month.
     *
     * @param int $month Month of the year.
     *
     * @return License[]|null
     */
    public function expireInMonth($month)
    {
        return $this->search('MONTH(license_expire) = :m AND YEAR(license_expire) = :y', [':m' => $month, ':y' => date('Y')]);
    }

    /**
     * Get licenses by invoice.
     *
     * @param int|string $invoice Invoice ID.
     *
     * @return License[]|null
     */
    public function getLicensesByInvoice($invoice)
    {
        return $this->search('license_invoice = :in', [':in' => $invoice]);
    }

} 