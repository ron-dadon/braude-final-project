<?php

namespace Application\Controllers;

class Quotes extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}