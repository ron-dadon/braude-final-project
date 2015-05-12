<?php

namespace Application\Controllers;

class Clients extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}