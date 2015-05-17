<?php

namespace Application\Controllers;

class Administration extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}