<?php

namespace Application\Controllers;

class Invoices extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}