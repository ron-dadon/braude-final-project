<?php


namespace Application\Controllers;


use Trident\MVC\AbstractController;
use Trident\Exceptions\ViewNotFoundException;
use Trident\MVC\AbstractView;

class IacsBaseController extends AbstractController
{

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

} 