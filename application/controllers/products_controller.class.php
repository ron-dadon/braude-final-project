<?php


class Products_Controller extends IACS_Controller
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->only_logged_in();
    }

    public function index()
    {
        $view_data['current-menu'] = 'products';
        $view_data['current-user'] = $this->get_connected_user_name();
        $this->load_view($view_data)->render();
    }

    public function show($id)
    {
        // TODO: implement show product information
    }

    public function edit($id)
    {
        // TODO: implement edit product information
    }

    public function delete($id)
    {
        // TODO: implement delete product
    }

    public function export_to_excel($id)
    {
        // TODO: implement export to excel of product information
    }

    public function export_to_pdf($id)
    {
        // TODO: implement export to pdf of product information
    }

    public function export_list()
    {
        // TODO: implement export to excel the list of products
    }
}