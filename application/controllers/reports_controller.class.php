<?php


class Reports_Controller extends IACS_Controller
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->only_logged_in();
    }

    public function index()
    {
        $view_data['current-menu'] = 'reports';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

}