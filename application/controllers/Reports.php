<?php

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
        $this->getView()->render();
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
        $list = $licenses->search("DATEDIFF(:todate,license_expire) BETWEEN 0 AND :days ", [':todate'=>$now, ':days'=>$days]);
        if ($list === null)
        {
            $this->getLog()->newEntry("Failed to retrieve licenses from the database", "database");
            $this->setSessionAlertMessage("Error generating report. Please check system log for further information.","error");
            $this->redirect('/Reports');
        }
        var_dump($list);
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
            // Go to reports
        }
        var_dump($list);

    }

    /**
     * Open invoices report.
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
            // Go to reports
        }
        var_dump($list);
    }

}