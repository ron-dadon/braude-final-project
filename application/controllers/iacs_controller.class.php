<?php


abstract class IACS_Controller extends Trident_Abstract_Controller
{

    protected function get_connected_user_name()
    {
        return 'דן נתניהו';
    }

    protected function only_connected()
    {
        if ($this->session->get('user-logged') !== true)
        {
            $this->redirect('/login');
        }
    }

    protected function only_admin()
    {
        if ($this->session->get('user-admin') !== true)
        {
            $this->redirect('/');
        }
    }

} 