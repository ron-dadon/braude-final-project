<?php

namespace Application\Controllers;

class Error extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}