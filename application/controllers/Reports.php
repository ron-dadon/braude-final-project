<?php

namespace Application\Controllers;

class Reports extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}