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
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        $view_data['clients-list'] = $clients->get_all();
        $view_data['client-delete'] = $this->session->pull('client-delete');
        $view_data['client-delete-name'] = $this->session->pull('client-delete-name');
        $this->load_view($view_data)->render();
    }

    public function show_client($id)
    {
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        /** @var Client_Entity $client */
        $client = $clients->get_client_by_id($id);
        /** @var Contacts_Model $contacts */
        $contacts = $this->load_model('contacts');
        /** @var Contact_Entity[] $client_contacts */
        $client_contacts = $contacts->get_all_for_client($client);
        if ($client === null || $client_contacts === null)
        {
            $this->redirect('/error');
        }
        $view_data['client'] = $client;
        $view_data['contacts'] = $client_contacts;
        $view_data['client-edit'] = $this->session->pull('client-edit');
        $view_data['client-edit-name'] = $this->session->pull('client-edit-name');
        $this->load_view($view_data)->render();
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
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        $client = $clients->get_client_by_id($id);
        if ($client === null)
        {
            $this->redirect('/error');
        }
        if ($this->request->type === 'POST')
        {
            $new_client = new Client_Entity();
            $new_client->data_from_post($this->request->post, 'client_');
            $new_client->created_on = $client->created_on;
            $new_client->delete = $client->delete;
            $new_client->id = $client->id;
            $this->session->set('client-edit', $clients->update_client($new_client));
            $this->session->set('client-edit-name', $new_client->name);
            $this->redirect('/clients/show/' . $client->id);
            exit();
        }
        $view_data['client'] = $client;
        $this->load_view($view_data)->render();
    }

    public function edit_client_contact($contact_id)
    {
        // TODO: implement edit client contact information
    }

    public function delete_client($id)
    {
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        $client = $clients->get_client_by_id($id);
        if ($client === null)
        {
            $this->redirect('/error');
        }
        $this->session->set('client-delete', $clients->delete_client($client));
        $this->session->set('client-delete-name', $client->name);
        $this->redirect('/clients');
    }

    public function delete_client_contact($contact_id)
    {
        // TODO: implement delete client contact
    }

}