<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

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