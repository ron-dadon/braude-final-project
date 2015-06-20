<?php

namespace Application\Controllers;

/**
 * Class Error
 *
 * This class provides the logic layer for error display.
 *
 * @package Application\Controllers
 */
class Error extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

}