<?php

namespace Application\Controllers;

use \Application\Models\Licenses;
use \Application\Models\Clients;
use \Application\Models\Products;
use \Application\Models\Invoices;
use \Application\Models\LicenseTypes;
use \Application\Entities\License;

class Reports extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

    public function ExpiredLicenses()
    {
        /** @var Licenses $licenses */
        $licenses = $this->loadModel('Licenses');
        $now = date('Y-m-d');
        $list = $licenses->search("license_expire < '$now'", []);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve licenses from the database", "database");
            // Go to reports
        }
        /** @var Clients $clients */
        $clients = $this->loadModel('Clients');
        /** @var Products $products */
        $products = $this->loadModel('Products');
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel('LicenseTypes');
        /** @var Invoices $invoices */
        $invoices = $this->loadModel('Invoices');
        /**
         * @var License $license
         */
        foreach ($list as $key => $license)
        {
            if ($license->client !== null)
            {
                $license->client = $clients->getById($license->client);
            }
            if ($license->product !== null)
            {
                $license->product = $products->getById($license->product);
            }
            if ($license->type !== null)
            {
                $license->type = $licenseTypes->getById($license->type);
            }
            if ($license->invoice !== null)
            {
                $license->invoice = $invoices->getById($license->invoice);
            }
            $list[$key] = $license;
        }
        var_dump($list, $this->getLoggedUser());
    }

    public function QuotesByStatus ($status)
    {
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');

        $list = $quotes->search("quote_status = :status", [':status' =>$status ]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve quotes from the database", "database");
            // Go to reports
        }
        /** @var Products $products */
        $products = $this->loadModel('Products');
        /** @var Clients $clients */
        $clients = $this->loadModel('Clients');
        /**
         * @var Quote $quote
         */
        foreach ($list as $key => $quote)
        {
            if ($quote->client !== null)
            {
                $quote->client = $clients->getById($quote->client);
            }
            if ($quote->product !== null)
            {
                $quote->product = $products->getById($quote->product);
            }

            $list[$key] = $quote;
        }
        var_dump($list);

    }

    public function OpenInvoices ()
    {
        /** @var Invoices $invoices */
        $invoices = $this->loadModel('Invoices');

        $list = $invoices->search("invoice_tax = ''",[]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve invoices from the database", "database");
            // Go to reports
        }
        /** @var Products $products */
        $products = $this->loadModel('Products');
        /** @var Clients $clients */
        $clients = $this->loadModel('Clients');
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');

        /**
         * @var Invoice $invoice
         */
        foreach ($list as $key => $invoice)
        {
            if ($invoice->client !== null)
            {
                $invoice->client = $clients->getById($invoice->client);
            }
            if ($invoice->product !== null)
            {
                $invoice->products = $products->getById($invoice->product);
            }
            if ($invoice->quote !== null)
            {
                $invoice->quote = $products->getById($invoice->quote);
            }

            $list[$key] = $invoice;
        }
        var_dump($list);
    }

    /*public function ExpieredLicense ($status)
    {
*/
}