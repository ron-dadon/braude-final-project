<?php


class Management_Controller extends IACS_Controller
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->only_logged_in();
        $this->only_admin();
    }

    public function index()
    {
        $view_data['current-menu'] = 'management';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function show_users()
    {
        // TODO: implement show users list
    }

    public function add_user()
    {
        // TODO: implement add a new user
    }

    public function edit_user($id)
    {
        // TODO: implement editing user information
    }

    public function delete_user($id)
    {
        // TODO: implement deleting user
    }

    public function settings()
    {
        // TODO: implement settings management
    }
}