<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Invoice;

class Invoices extends AbstractModel
{

    public function getById($id)
    {
        return $this->getORM()->findById('Invoice', $id, "invoice_delete = 0");
    }

    public function getAll()
    {
        return $this->getORM()->find('Invoice', "invoice_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search invoice values mush be an array");
        }
        return $this->getORM()->find('Invoice',"$term AND invoice_delete = 0", $values);
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
        return $this->getORM()->save($invoice);

    }
} 