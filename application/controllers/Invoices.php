<?php

namespace Application\Controllers;

use Application\Entities\Invoice;
use Application\Models\Invoices as InvoicesModel;

class Invoices extends IacsBaseController
{
    public function Index()
    {
        /** @var InvoicesModel $invoices */
        $invoices = $this->loadModel("Invoices");
        $viewData['invoices'] = $invoices->getAll();
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

    public function Add()
    {
        $invoice = new Invoice();
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $invoice->fromArray($data, "invoice_");
            if ($invoice->isValid())
            {
                $result = $this->getORM()->save($invoice);
                if ($result->isSuccess())
                {
                    $invoice->id = $result->getLastId();
                    $this->addLogEntry("Created invoice with ID: " . $invoice->id, "success");
                    // Add go to show invoice
                }
                else
                {
                    $viewData['error'] = "Error adding invoice to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding invoice to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new invoice", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error adding invoice";
                $this->addLogEntry("Failed to create a new invoice - invalid data", "danger");
            }
        }
        $viewData['invoice'] = $invoice;
        $this->getView($viewData)->render();
    }

    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var InvoicesModel $invoices */
            $invoices = $this->loadModel('Invoices');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                /** @var Invoice $invoice */
                $invoice = $invoices->getById($id);
                if ($invoice === null)
                {
                    $this->addLogEntry("Failed to delete invoice - supplied ID is invalid", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to invoice show
                    }
                }
                $result = $invoices->delete($invoice);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Invoice with ID " . $id . " delete successfully", "success");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(true, ['invoice' => $invoice->id]);
                    }
                    else
                    {
                        // Go to invoice list
                    }
                }
                else
                {
                    $this->getLog()->newEntry("Failed to delete invoice with ID " . $id . ": " . $result->getErrorString(), "database");
                    $this->addLogEntry("Failed to delete invoice from the database. Check the errors log for further information, or contact your system administrator.", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to invoice show
                    }
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->addLogEntry("Failed to delete invoice - no ID supplied", "danger");
                if ($this->getRequest()->isAjax())
                {
                    $this->jsonResponse(false);
                }
                else
                {
                    // Go to invoice show
                }
            }
        }
        $this->getView()->render();
    }

    public function Update($id)
    {
        /** @var InvoicesModel $invoices */
        $invoices = $this->loadModel('Invoices');
        /** @var Invoice $invoice */
        $invoice = $invoices->getById($id);
        if ($invoice === null)
        {
            $this->redirect("/Invoice");
        }
        if ($this->getRequest()->isAjax())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $invoice->fromArray($data, "invoice_");
            if ($invoice->isValid())
            {
                $result = $this->getORM()->save($invoice);
                if ($result->isSuccess())
                {
                    $invoice->id = $result->getLastId();
                    $this->addLogEntry("Updated invoice with ID: " . $invoice->id, "success");
                    $this->jsonResponse(true);
                }
                else
                {
                    $viewData['error'] = "Error updating invoice to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating invoice in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update invoice", "danger");
                    $this->jsonResponse(false);
                }
            }
            else
            {
                $viewData['error'] = "Error updating invoice";
                $this->addLogEntry("Failed to update invoice - invalid data", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['invoice'] = $invoice;
        $this->getView($viewData)->render();
    }


}