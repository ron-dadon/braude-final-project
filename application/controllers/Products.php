<?php

namespace Application\Controllers;

class Products extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}