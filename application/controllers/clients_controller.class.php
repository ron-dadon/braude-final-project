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
        $view_data['client-add'] = $this->session->pull('client-add');
        $view_data['client-add-name'] = $this->session->pull('client-add-name');
        $view_data['contact-delete'] = $this->session->pull('contact-delete');
        $view_data['contact-delete-name'] = $this->session->pull('contact-delete-name');
        $view_data['contact-add'] = $this->session->pull('contact-add');
        $view_data['contact-add-name'] = $this->session->pull('contact-add-name');
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

    public function add_client()
    {
        $view_data = [];
        if ($this->request->type === 'POST')
        {
            $new_client = new Client_Entity();
            $new_client->data_from_post($this->request->post, 'client_');
            $new_client->created_on = date('Y-m-d');
            $new_client->delete = 0;
            $new_client->id = null;
            /** @var Clients_Model $clients */
            $clients = $this->load_model('clients');
            $result = $clients->add_client($new_client);
            if ($result->success)
            {
                $this->session->set('client-add', true);
                $this->session->set('client-add-name', $new_client->name);
                $this->redirect('/clients/show/' . $result->last_inserted_id);
            }
            else
            {
                $view_data['client-add-error'] = true;
            }
        }
        $this->load_view($view_data)->render();
    }

    public function add_client_contact($client_id)
    {
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        /** @var Client_Entity $client */
        $client = $clients->get_client_by_id($client_id);
        if ($client === null)
        {
            $this->redirect('/error');
        }
        if ($this->request->type === 'POST')
        {
            /** @var Contact_Entity $new_contact */
            $new_contact = new Contact_Entity();
            $new_contact->data_from_post($this->request->post, 'contact_');
            $new_contact->client = $client->id;
            $new_contact->delete = 0;
            $new_contact->id = null;
            /** @var Contacts_Model $contacts */
            $contacts = $this->load_model('contacts');
            $result = $contacts->add_contact($new_contact);
            $this->session->set('contact-add', $result->success);
            $this->session->set('contact-add-name', $new_contact->first_name . ' ' . $new_contact->last_name);
            $this->redirect('/clients/show/' . $client->id);
        }
        $view_data['client'] = $client;
        $this->load_view($view_data)->render();
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

    public function delete_client_contact($id)
    {
        /** @var Contacts_Model $contacts */
        $contacts = $this->load_model('contacts');
        /** @var Contact_Entity $contact */
        $contact = $contacts->get_contact_by_id($id);
        if ($contact === null)
        {
            $this->redirect('/error');
        }
        $this->session->set('contact-delete', $contacts->delete_contact($contact));
        $this->session->set('contact-delete-name', $contact->first_name . ' ' . $contact->last_name);
        $this->redirect('/clients/show/' . $contact->client);
    }

    public function export_clients()
    {
        /** @var Xlsx_Library $excel */
        $excel = $this->load_library('xlsx');
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        $clients_list = $clients->get_all();
        if ($clients_list === null)
        {
            $this->redirect('/error');
        }
        $data = [];
        /** @var Client_Entity $client */
        foreach ($clients_list as $client)
        {
            $data[] = array_values(array_diff_key($client->get_fields(), ['delete' => '', 'created_on' => '']));
        }
        $headers = ['מספר' => 'string', 'שם' => 'string', 'כתובת' => 'string', 'טלפון' => 'string', 'פקס' => 'string', 'דואר אלקטרוני' => 'string', 'אתר אינטרנט' => 'string'];
        $excel->set_author('IACS מערכת מידע');
        $excel->write_sheet($data, 'רשימת לקוחות', $headers);
        $this->download_data($excel->write_to_string(), 'רשימת לקוחות.xlsx');
    }

    public function export_contacts($id)
    {
        /** @var Xlsx_Library $excel */
        $excel = $this->load_library('xlsx');
        /** @var Clients_Model $clients */
        $clients = $this->load_model('clients');
        /** @var Client_Entity $client */
        $client = $clients->get_client_by_id($id);
        if ($client === null)
        {
            $this->redirect('/error');
        }
        /** @var Contacts_Model $contacts */
        $contacts = $this->load_model('contacts');
        /** @var Contact_Entity[] $contacts_list */
        $contacts_list = $contacts->get_all_for_client($client);
        $data = [];
        /** @var Contact_Entity $contact */
        foreach ($contacts_list as $contact)
        {
            $data[] = array_values(array_diff_key($contact->get_fields(), ['client' => '', 'delete' => '']));
        }
        $headers = [
            'מספר' => 'string',
            'שם פרטי' => 'string',
            'שם משפחה' => 'string',
            'טלפון' => 'string',
            'פקס' => 'string',
            'דואר אלקטרוני' => 'string',
            'תפקיד' => 'string'
        ];
        $excel->set_author('IACS מערכת מידע');
        $excel->write_sheet($data, 'רשימת אנשי קשר ' . $client->name, $headers);
        $this->download_data($excel->write_to_string(), 'אנשי קשר עבור לקוח ' . $client->name . '.xlsx');
    }

}