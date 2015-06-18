<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Invoice;
use Trident\Database\Query;

class Invoices extends AbstractModel
{

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

    public function count()
    {
        $query = new Query('SELECT COUNT(invoice_id) AS counter FROM invoices WHERE invoice_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    public function getAll()
    {
        $list = $this->getORM()->find('Invoice', "invoice_delete = 0");
        foreach ($list as $key => $item) {
            /** @var Invoice $item */
            $list[$key] = $this->getById($item->id);
        }
        return $list;
    }

    public function getUnpaid()
    {
        $list = $this->getORM()->find('Invoice', "invoice_delete = 0 AND invoice_tax = ''");
        foreach ($list as $key => $item) {
            /** @var Invoice $item */
            $list[$key] = $this->getById($item->id);
        }
        return $list;
    }

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
     * @param Invoice $invoice
     *
     * @return \Trident\Database\Result
     */
    public function add($invoice)
    {
        return $this->getORM()->save($invoice);
    }
    /**
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

} 