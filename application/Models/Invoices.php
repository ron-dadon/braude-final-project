<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Invoice;
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
     * @throws \Trident\Exceptions\EntityNotFoundException
     * @throws \Trident\Exceptions\ModelNotFoundException
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
     * @throws \Trident\Exceptions\MySqlException
     */
    public function count()
    {
        $query = new Query('SELECT COUNT(invoice_id) AS counter FROM invoices WHERE invoice_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    /**
     * Get all the invoices from the database.
     *
     * @return \Trident\ORM\Entity[]|null
     * @throws \Trident\Exceptions\EntityNotFoundException
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
     * An unpaid invoice is an invoice without a tax invoice number.
     *
     * @return null|\Trident\ORM\Entity[]
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getUnpaid()
    {
        $list = $this->getORM()->find('Invoice', "invoice_delete = 0 AND invoice_tax = ''");
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
     * @return null|\Trident\ORM\Entity[]
     * @throws \Trident\Exceptions\EntityNotFoundException
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
     * Add a new invoice to the database.
     *
     * @param Invoice $invoice
     *
     * @return \Trident\Database\Result
     */
    public function add($invoice)
    {
        return $this->getORM()->save($invoice);
    }
    /**
     * Delete an invoice from the database.
     * Performs a soft-delete.
     * Sets related quote status to APPROVED.
     *
     * @param Invoice $invoice
     *
     * @return \Trident\Database\Result
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
     * @throws \Trident\Exceptions\MySqlException
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
     * @throws \Trident\Exceptions\MySqlException
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

} 