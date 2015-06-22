<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Controllers;

use Application\Entities\Invoice;
use Application\Models\Invoices as InvoicesModel;
use Application\Models\Quotes;
use Application\Models\Licenses;

/**
 * Class Invoices
 *
 * This class provides the logic layer for the invoices data.
 *
 * @package Application\Controllers
 */
class Invoices extends IacsBaseController
{

    /**
     * Show all invoices.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
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

    /**
     * Show extended invoice information.
     *
     * @param string|int $id Invoice ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Show($id)
    {
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        /** @var InvoicesModel $invoices */
        $invoices = $this->loadModel('Invoices');
        /** @var Licenses $licenses */
        $licenses = $this->loadModel('Licenses');
        $invoice = $invoices->getById($id);
        if ($invoice === null) {
            $this->setSessionAlertMessage("Can't show invoice with ID " . htmlspecialchars($id) . ". Invoice doesn't exists.", "error");
            $this->redirect('/Invoices');
        }
        $viewData['licenses'] = $licenses->getLicensesByInvoice($invoice->id);
        $viewData['invoice'] = $invoice;
        $this->getView($viewData)->render();
    }

    /**
     * Add a new invoice based on a quote.
     *
     * @param string|int $quoteId The quote to base on.
     *
     * @throws \Trident\Exceptions\IOException
     */
    public function Add($quoteId)
    {
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($quoteId);
        if ($quote === null) {
            $this->setSessionAlertMessage("Can't create an invoice for the supplied quote ID: " . htmlspecialchars($quoteId), "error");
            $this->redirect('/Invoices');
        }
        $invoice = new Invoice();
        $invoice->quote = $quote;
        $invoice->client = $quote->client;
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $invoice->fromArray($data, "invoice_");
            if ($invoice->isValid())
            {
                $invoice->client = $invoice->client->id;
                $invoice->quote = $invoice->quote->id;
                $result = $this->getORM()->save($invoice);
                if ($result->isSuccess())
                {
                    $invoice->id = $result->getLastId();
                    $invoice->quote = $quote;
                    $invoice->quote->status = 5;
                    $this->getORM()->save($invoice->quote);
                    $this->addLogEntry("Created invoice with ID: " . $invoice->id, "success");
                    $this->setSessionAlertMessage("Invoice saved");
                    $this->redirect("/Invoices/Show/{$invoice->id}");
                }
                else
                {
                    $viewData['error'] = "Error saving invoice to the database. Check the errors log for further information, or contact your system administrator.";
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
        $invoice->quote = $quote;
        $invoice->client = $quote->client;
        $viewData['invoice'] = $invoice;
        $this->getView($viewData)->render();
    }

    /**
     * Delete an invoice.
     * Invoice ID must be supplied via POST delete_id.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
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

    /**
     * Update an invoice.
     * Invoice updated information need to be passed via POST.
     *
     * @param string|int $id Invoice ID.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
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
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $invoice->fromArray($data, "invoice_");
            if ($invoice->isValid())
            {
                $quote = $invoice->quote;
                $client = $invoice->client;
                $invoice->quote = $quote->id;
                $invoice->client = $client->id;
                $result = $this->getORM()->save($invoice);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Updated invoice with ID: " . $invoice->id, "success");
                    $this->setSessionAlertMessage("Invoice No. {$invoice->id} updated successfully");
                    $this->redirect('/Invoices/Show/' . $invoice->id);
                }
                else
                {
                    $invoice->quote = $quote;
                    $invoice->client = $client;
                    $viewData['error'] = "Error updating invoice to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating invoice in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update invoice {$invoice->id}", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error updating invoice";
                $this->addLogEntry("Failed to update invoice {$invoice->id} - invalid data", "danger");
            }
        }
        $viewData['invoice'] = $invoice;
        $this->getView($viewData)->render();
    }

    /**
     * Get all invoices of client and product.
     *
     * @param string|int $productId
     * @param string|int $clientId
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function InvoicesByProduct($productId, $clientId)
    {
        if (!$this->getRequest()->isAjax()) $this->redirect('/Error');
        /** @var InvoicesModel $invoices */
        $invoices = $this->loadModel("Invoices");
        $list = array_filter($invoices->getAll(), function($item) use ($productId,$clientId) {
            /** @var Invoice $item */
            if ($item->client->id != $clientId) return false;
            foreach ($item->quote->products as $p) {
                if ($p->product->id == $productId)
                {
                    return true;
                }
            }
            return false;
        });
        echo json_encode(array_values($list), JSON_UNESCAPED_UNICODE);
        exit();
    }

}