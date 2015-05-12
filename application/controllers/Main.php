<?php

namespace Application\Controllers;

class Main extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

    public function Error()
    {
        $this->getView()->render();
    }
} 