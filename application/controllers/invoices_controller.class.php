<?php


class Invoices_Controller extends IACS_Controller
{
    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->only_logged_in();
    }

    public function index()
    {
        $view_data['current-menu'] = 'invoices';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function show($id)
    {
        // TODO: implement show invoice information
    }

    public function update($id)
    {
        // TODO: implement update invoice information
    }

    public function delete($id)
    {
        // TODO: implement delete an invoice
    }

    public function export_to_excel($id)
    {
        // TODO: implement export invoice information to excel
    }

    public function export_to_pdf($id)
    {
        // TODO: implement export invoice information to pdf
    }

    public function export_list()
    {
        // TODO: implement export invoices list
    }

}