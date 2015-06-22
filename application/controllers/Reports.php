<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Controllers;

use \Application\Models\Licenses;
use \Application\Models\Clients;
use \Application\Models\Products;
use \Application\Models\Invoices;
use \Application\Models\LicenseTypes;
use \Application\Models\Quotes;
use \Application\Entities\License;
use \Application\Entities\Quote;
use Trident\Database\Query;
use Application\Entities\Invoice;
use Application\Entities\Product;

/**
 * Class Reports
 *
 * This class provides the logic layer for the reports.
 *
 * @package Application\Controllers
 */
class Reports extends IacsBaseController
{

    /**
     * Show reports list.
     */
    public function Index()
    {
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');
        $viewData['quote-status'] = $quotes->getAllStatuses();
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

    /**
     * Expired licenses report.
     *
     * @param int|string $days The number of days back to check.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function ExpiredLicenses($days)
    {
        if (!preg_match('/[0-9]+/',$days) || $days > 365)
        {
            $this->addLogEntry("Can't perform expired licenses report. Supplied days are invalid.","warning");
            $this->redirect('/Reports');
        }
        /** @var Licenses $licenses */
        $licenses = $this->loadModel('Licenses');
        $now = date('Y-m-d');
        $list = $licenses->search("DATEDIFF(:todate,license_expire) BETWEEN 1 AND :days ", [':todate'=>$now, ':days'=>$days]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve licenses from the database", "database");
            $this->addLogEntry("Failed to retrieve licenses from the database", "danger");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        if (!count($list))
        {
            $this->addLogEntry("Report Expired Licenses create successfully");
            $this->setSessionAlertMessage("Report Expired Licenses Within {$days} Days: no results");
            $this->redirect('/Reports');
        }
        $this->addLogEntry("Report Expired Licenses create successfully");
        $this->getView(['days' => $days, 'licenses' => $list])->render();
    }

    /**
     * Quotes by status report.
     *
     * @param string|int $status Quote status.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function QuotesByStatus($status)
    {
        /** @var Quotes $quotes */
        $quotes = $this->loadModel('Quotes');

        $list = $quotes->search("quote_status = :status", [':status' =>$status ]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve quotes from the database", "database");
            $this->addLogEntry("Failed to retrieve quotes from the database", "danger");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        if (!count($list))
        {
            $this->addLogEntry("Report Quotes By Status create successfully");
            $this->setSessionAlertMessage("Report Quotes By Status: no results");
            $this->redirect('/Reports');
        }
        $this->addLogEntry("Report Quotes By Status create successfully");
        var_dump($list);

    }

    /**
     * Open invoices report.
     *
     * An open invoice is a invoice that is not paid, meaning,
     * there is no tax invoice supplied.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function OpenInvoices()
    {
        /** @var Invoices $invoices */
        $invoices = $this->loadModel('Invoices');

        $list = $invoices->search("invoice_tax = ''",[]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve invoices from the database", "database");
            $this->addLogEntry("Failed to retrieve invoices from the database", "danger");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        if (!count($list))
        {
            $this->addLogEntry("Report Open Invoices create successfully");
            $this->setSessionAlertMessage("Report Open Invoices: no results");
            $this->redirect('/Reports');
        }
        $this->addLogEntry("Report Open Invoices create successfully");
        var_dump($list);
    }

    /**
     * Perform products sales report.
     * The report includes a list of the products and the amount
     * of items sold, by summing up the products from the invoices.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function ProductsSales()
    {
        /** @var Invoices $invoices */
        $invoices = $this->loadModel('Invoices');
        /** @var Products $products */
        $products = $this->loadModel('Products');
        $list = $invoices->getAll();
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve invoices from the database", "database");
            $this->addLogEntry("Failed to retrieve invoices from the database", "danger");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        $counts = [];
        $total = 0;
        /** @var Invoice $invoice */
        foreach ($list as $invoice) {
            foreach ($invoice->quote->products as $p) {
                if (isset($counts[$p->product->id])) {
                    $counts[$p->product->id]['count'] += $p->quantity;
                } else {
                    $counts[$p->product->id]['count'] = $p->quantity;
                    $counts[$p->product->id]['product'] = $p->product;
                }
                $total += $p->quantity;
            }
        }
        if (!count($counts))
        {
            $this->addLogEntry("Report Products Sales create successfully");
            $this->setSessionAlertMessage("Report Products Sales: no products sales");
            $this->redirect('/Reports');
        }
        $prods = $products->getAll();
        if ($prods === null)
        {
            $this->getLog()->newEntry("Failed to retrieve products from the database", "database");
            $this->addLogEntry("Failed to retrieve products from the database", "danger");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        foreach($prods as $p) {
            if (!isset($counts[$p->id])) {
                $counts[$p->id]['count'] = 0;
                $counts[$p->id]['product'] = $p;
            }
        }
        arsort($counts);
        $viewData['counts'] = $counts;
        $viewData['total'] = $total;
        $this->addLogEntry("Report Products Sales create successfully");
        $this->getView($viewData)->render();
    }
}