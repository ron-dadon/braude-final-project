<?php

namespace Application\Controllers;

use Application\Entities\Client;
use Application\Models\Clients as ClientsModel;

class Clients extends IacsBaseController
{

    public function Index()
    {
        /** @var ClientsModel $clients */
        $clients = $this->loadModel('Clients');
        $list = $clients->getAll();
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $viewData['clients'] = $list;
        $this->getView($viewData)->render();
    }

    public function Add()
    {
        $client = new Client();
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $client->fromArray($data, "client_");
            try
            {
                $goToEdit = $this->getRequest()->getPost()->item('redirect_update');
            }
            catch (\InvalidArgumentException $e)
            {
                $goToEdit = false;
            }
            if ($client->isValid())
            {
                $result = $this->getORM()->save($client);

                if ($result->isSuccess())
                {
                    $client->id = $result->getLastId();
                    $this->addLogEntry("Created client with ID: " . $client->id, "success");
                    $this->setSessionAlertMessage("Client " . $client->name . " created successfully.");
                    if ($goToEdit)
                    {
                        $this->redirect("/Clients/Update/" . $client->id);
                    }
                    $this->redirect("/Clients");
                }
                else
                {
                    $viewData['error'] = "Error adding client to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding client to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new client", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error adding client";
                $this->addLogEntry("Failed to create a new client - invalid data", "danger");
            }
        }
        $viewData['client'] = $client;
        $this->getView($viewData)->render();
    }

    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var ClientsModel $clients */
            $clients = $this->loadModel('Clients');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                $client = $clients->getById($id);
                if ($client === null)
                {
                    $this->addLogEntry("Failed to delete client - supplied ID is invalid", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to client show
                    }
                }
                $result = $clients->delete($client);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Client with ID " . $id . " delete successfully", "success");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(true, ['client' => addslashes(htmlspecialchars($client->name, ENT_NOQUOTES))]);
                    }
                    else
                    {
                        // Go to client list
                    }
                }
                else
                {
                    $this->getLog()->newEntry("Failed to delete client with ID " . $id . ": " . $result->getErrorString(), "database");
                    $this->addLogEntry("Failed to delete client from the database. Check the errors log for further information, or contact your system administrator.", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to client show
                    }
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->addLogEntry("Failed to delete client - no ID supplied", "danger");
                if ($this->getRequest()->isAjax())
                {
                    $this->jsonResponse(false);
                }
                else
                {
                    // Go to client show
                }
            }
        }
    }

    public function Update($id)
    {
        /** @var ClientsModel $clients */
        $clients = $this->loadModel('Clients');
        $client = $clients->getById($id);
        if ($client === null)
        {
            $this->setSessionAlertMessage("Can't edit client with ID $id. Client was not found.", "error");
            $this->redirect("/Clients");
        }
        if ($this->getRequest()->isAjax())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $client->fromArray($data, "client_");
            if ($client->isValid())
            {
                $result = $this->getORM()->save($client);
                if ($result->isSuccess())
                {
                    $client->id = $result->getLastId();
                    $this->addLogEntry("Updated client with ID: " . $client->id, "success");
                    $this->jsonResponse(true);
                }
                else
                {
                    $viewData['error'] = "Error updating client to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating client in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update client", "danger");
                    $this->jsonResponse(false);
                }
            }
            else
            {
                $viewData['error'] = "Error updating client";
                $this->addLogEntry("Failed to update client - invalid data", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['client'] = $client;
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

    public function AddContact()
    {
        $this->getView()->render();
    }

    public function DeleteContact()
    {
        $this->getView()->render();
    }

    public function UpdateContact()
    {
        $this->getView()->render();
    }
}