<?php


abstract class IACS_Controller extends Trident_Abstract_Controller
{

    protected function get_connected_user_name()
    {
        return $this->session->get('user-name');
    }

    protected function only_logged_in()
    {
        if (!$this->is_logged_in())
        {
            $this->redirect('/login');
        }
    }

    protected function only_admin()
    {
        if (!$this->is_admin())
        {
            $this->redirect('/');
        }
    }

    public function is_logged_in()
    {
        return $this->session->get('user-logged') === true;
    }

    public function is_admin()
    {
        return $this->session->get('user-admin') === true;
    }

    protected function load_view($view_data = [], $view = null)
    {
        if (is_null($view))
        {
            $view = debug_backtrace()[1]['function'];
            $view = str_replace('_controller', '', strtolower(get_class($this))) . '_' . $view . '_view';
        }
        $view_data['is_admin'] = $this->is_admin();
        return parent::load_view($view_data, $view);
    }
}