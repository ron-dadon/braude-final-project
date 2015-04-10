<?php


class Products_Controller extends IACS_Controller
{

    public function index()
    {
        $view_data['current-menu'] = 'products';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

}