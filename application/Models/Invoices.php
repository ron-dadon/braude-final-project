<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\ModelNotFoundException;
use Trident\Exceptions\MySqlException;
use Application\Entities\Invoice;
use Application\Entities\Product;
use Trident\Database\Query;

/**
 * Class Invoices
 *
 * This class provides the data-access layer to the invoices in the database.
 *
 * @package Application\Models
 */
class Invoices extends AbstractModel
{

    /**
     * Get invoice by it's ID.
     *
     * @param string|int $id Invoice ID.
     *
     * @return Invoice
     *
     * @throws EntityNotFoundException
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        /** @var Invoice $invoice */
        $invoice = $this->getORM()->findById('Invoice', $id, "invoice_delete = 0");
        if ($invoice === null) return null;
        $invoice->client = $this->getORM()->findById('Client', $invoice->client);
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');
        $invoice->quote = $quotes->getById($invoice->quote);
        return $invoice;
    }

    /**
     * Get invoices count.
     *
     * @return int
     *
     * @throws MySqlException
     */
    public function count()
    {
        $query = new Query('SELECT COUNT(invoice_id) AS counter FROM invoices WHERE invoice_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    /**
     * Get all the invoices in the system.
     *
     * @return Invoice[]|null
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        $list = $this->getORM()->find('Invoice', "invoice_delete = 0");
        if ($list === null) return null;
        foreach ($list as $key => $item) {
            /** @var Invoice $item */
            $list[$key] = $this->getById($item->id);
        }
        return $list;
    }

    /**
     * Get all unpaid invoices.
     *
     * An unpaid invoice is an invoice without a tax invoice number.
     *
     * @return Invoice[]|null
     * @throws EntityNotFoundException
     */
    public function getUnpaid()
    {
        $list = $this->getORM()->find('Invoice', "invoice_delete = 0 AND invoice_tax = '' AND DATEDIFF(NOW(), invoice_date) > invoice_terms");
        if ($list === null) return null;
        foreach ($list as $key => $item) {
            /** @var Invoice $item */
            $list[$key] = $this->getById($item->id);
        }
        return $list;
    }

    /**
     * Search for invoices.
     *
     * @param string $term Search term (SQL Where condition)
     * @param array $values Values of the search term parameters.
     *
     * @return Invoice[]|null
     * @throws EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search invoice values mush be an array");
        }
        $list = $this->getORM()->find('Invoice',"$term AND invoice_delete = 0", $values);
        foreach ($list as $key => $item) {
            /** @var Invoice $item */
            $list[$key] = $this->getById($item->id);
        }
        return $list;
    }

    /**
     * Add a new invoice to the system.
     *
     * @param Invoice $invoice
     *
     * @return Result
     */
    public function add($invoice)
    {
        return $this->getORM()->save($invoice);
    }

    /**
     * Delete an invoice from the system.
     *
     * Performs a soft-delete.
     * Sets related quote status to APPROVED.
     *
     * @param Invoice $invoice
     *
     * @return Result
     */
    public function delete($invoice)
    {
        $invoice->delete = 1;
        $invoice->quote->status = 4;
        $result = $this->getORM()->save($invoice);
        if (!$result->isSuccess()) return $result;
        return $this->getORM()->save($invoice->quote);

    }

    /**
     * Get invoices count by months for the current year.
     *
     * @return array Array of the count per months (1 to 12)
     *
     * @throws MySqlException
     */
    public function getByMonth()
    {
        $query = new Query('SELECT MONTH(invoice_date) AS m, COUNT(invoice_id) AS c FROM invoices WHERE invoice_delete = 0 AND YEAR(invoice_date) = :y GROUP BY MONTH(invoice_date)', [':y' => date('Y')]);
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) {
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[$i] = 0;
            }
            return $result;
        }
        $result = [];
        foreach ($query->getResultSet() as $row) {
            $result[$row['m']] = $row['c'];
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($result[$i]))
                $result[$i] = 0;
        }
        return $result;
    }

    /**
     * Get invoices income by months for the current year.
     *
     * @return array Array of the income per months (1 to 12) with total and total + tax fields.
     *
     * @throws MySqlException
     */
    public function getIncomeByMonth()
    {
        $query = new Query('SELECT MONTH(invoice_date) AS m, invoice_id FROM invoices WHERE invoice_delete = 0 AND YEAR(invoice_date) = :y', [':y' => date('Y')]);
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) {
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[$i] = 0;
            }
            return $result;
        }
        $result = [];
        foreach ($query->getResultSet() as $row) {
            $result[$row['m']][] = $row['invoice_id'];
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($result[$i])) {
                $result['total'][$i] = 0;
                $result['total-tax'][$i] = 0;
            }
            else {
                $total = 0;
                $totalTax = 0;
                foreach ($result[$i] as $id) {
                    $invoice = $this->getById($id);
                    $total += $invoice->quote->getSubTotal();
                    $totalTax += $invoice->quote->getTotalWithTax();
                }
                $result['total'][$i] = intval($total);
                $result['total-tax'][$i] = intval($totalTax);
            }
        }
        return $result;
    }

    /**
     * Get the top selling product from the invoices data.
     *
     * @param int $count The number of product to get.
     *
     * @return Product[]|null
     */
    public function getTopSellingProducts($count = 3)
    {
        $invoices = $this->getAll();
        $quotes = array_map(function($item) { return $item->quote; }, $invoices);
        $sells = [];
        $products = [];
        foreach ($quotes as $quote) {
            if ($quote->status->id != 5) continue;
            foreach ($quote->products as $p)
            {
                if (!isset($sells[$p->product->id]))
                {
                    $sells[$p->product->id] = 0;
                }
                if (!isset($products[$p->product->id]))
                {
                    $products[$p->product->id] = $p->product;
                }
                $sells[$p->product->id] += $p->quantity;
            }
        }
        arsort($sells);
        if (count($sells) > $count) {
            $sells = array_slice($sells, 0, $count, true);
        }
        $result = [];
        $i = count($sells);
        foreach ($sells as $key => $count) {
            $result[$i]['product'] = $products[$key];
            $result[$i]['count'] = $count;
            $i--;
        }
        krsort($result);
        return $result;
    }

} 