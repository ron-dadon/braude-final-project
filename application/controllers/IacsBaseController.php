<?php


namespace Application\Controllers;

use Trident\MVC\AbstractController;
use Trident\Exceptions\ViewNotFoundException;
use Trident\MVC\AbstractView;
use Application\Entities\User;

class IacsBaseController extends AbstractController
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->loadMySql();
        $this->loadORM();
    }

    /**
     * Load view instance.
     * If $view is not specified, loads the view according to the calling callable.
     *
     * @param array $viewData View data array.
     * @param null  $viewName View name.
     *
     * @throws ViewNotFoundException
     * @return AbstractView View instance.
     */
    protected function getView($viewData = [], $viewName = null)
    {
        $reflect = new \ReflectionClass($this);
        $class = $reflect->getShortName();
        $viewData['currentMenuItem'] = $class;
        if (is_null($viewName))
        {
            $viewName = debug_backtrace()[1]['function'];
            $viewName = "$class\\$viewName";
        }
        return parent::getView($viewData, $viewName);
    }

    /**
     * Check if user is logged in.
     *
     * @return bool True if logged in, false otherwise.
     */
    protected function isUserLogged()
    {
        try
        {
            $this->getSession()->item('iacs-logged-user');
            return true;
        }
        catch (\InvalidArgumentException $e)
        {
            return false;
        }
    }

    /**
     * Check if user have a privilege.
     *
     * @param string $privilege Privilege name.
     *
     * @return bool True if user have privilege, false otherwise.
     */
    protected function isUserAllowed($privilege)
    {
        /** @var User $user */
        $user = unserialize($this->getSession()->item('iacs-logged-user'));
        $data = $user->toArray();
        return isset($data[$privilege]) && $data[$privilege] == 1;
    }

    protected function jsonResponse($result, $details = [])
    {
        $json = ['result' => $result, 'details' => $details];
        echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }
}