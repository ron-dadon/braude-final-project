<?php


class Main_Controller extends IACS_Controller
{

    public function index()
    {
        $view_data['current-menu'] = 'home';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function search()
    {

    }

    public function error()
    {
        $this->load_view()->render();
    }
} 