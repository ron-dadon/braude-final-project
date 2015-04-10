<?php


class Clients_Controller extends IACS_Controller
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->only_logged_in();
    }

    public function index()
    {
        $view_data['current-menu'] = 'clients';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function show_client($id)
    {
        // TODO: implement show client information
    }

    public function show_client_contacts($id)
    {
        // TODO: implement show client contacts list
    }

    public function show_client_contact($contact_id)
    {
        // TODO: implement show client contact information
    }

    public function edit_client($id)
    {
        // TODO: implement edit client information
    }

    public function edit_client_contact($contact_id)
    {
        // TODO: implement edit client contact information
    }

    public function delete_client($id)
    {
        // TODO: implement delete client
    }

    public function delete_client_contact($contact_id)
    {
        // TODO: implement delete client contact
    }

}