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
}