<?php


class Clients_Controller extends IACS_Controller
{

    public function index()
    {
        $view_data['current-menu'] = 'clients';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

}