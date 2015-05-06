<?php

/**
 * Class Clients_Controller
 *
 * Handles all of the clients data in the system.
 * Allow for listing, showing information, adding, editing and deleting of clients.
 */
class Clients_Controller extends IACS_Controller
{

    /**
     * List all the clients in the system.
     * Show the clients list table.
     */
    public function index()
    {

    }

    /**
     * Add new client.
     * Client data comes from a POST request.
     */
    public function add()
    {

    }

    /**
     * Show client information.
     * Client id is provided through the URI.
     *
     * @param int $id Client id.
     */
    public function show($id)
    {

    }

    /**
     * Edit client information.
     * Client id is provided through the URI.
     * Updated client data comes from a POST request.
     *
     * @param int $id Client id.
     */
    public function edit($id)
    {

    }

    /**
     * Delete a client.
     * Client id is provided through POST request.
     */
    public function delete()
    {

    }

    /**
     * Export the clients list to the requested format.
     * Supported formats: HTML, XML, CSV, Excel 2007+
     *
     * @param string $type The type of export (case insensitive).
     */
    public function export_all($type = 'html')
    {

    }

    /**
     * Export client data to the requested format.
     * Supported formats: HTML, XML, CSV, Excel 2007+
     *
     * @param int $id The client id number.
     * @param string $type The type of export (case insensitive).
     */
    public function export_single($id, $type = 'html')
    {

    }

}