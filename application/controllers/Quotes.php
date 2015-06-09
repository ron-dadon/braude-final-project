<?php

namespace Application\Controllers;

use Application\Entities\Quote;
use Application\Models\Clients;
use Application\Models\Quotes as QuotesModel;

class Quotes extends IacsBaseController
{

    public function Index()
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel("Quotes");
        $viewData['quotes'] = $quotes->getAll();
        $this->getView($viewData)->render();
    }

    public function Add($clientId = null)
    {
        $quote = new Quote();
        /** @var Clients $clients */
        $clients = $this->loadModel("Clients");
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel("Quotes");
        if ($clientId !== null)
        {
            $client = $clients->getById($clientId);
            if ($client === null)
            {
                $this->setSessionAlertMessage("Can't create quote for client with ID {$clientId}. Client was not found.", "error");
                $this->redirect("/Clients");
            }
            $quote->client = $client;
        }
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $quote->fromArray($data, "quote_");
            if ($quote->isValid())
            {
                $result = $this->getORM()->save($quote);
                if ($result->isSuccess())
                {
                    $quote->id = $result->getLastId();
                    $this->addLogEntry("Created quote with ID: " . $quote->id, "success");
                    // Add go to show quote
                }
                else
                {
                    $viewData['error'] = "Error adding quote to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding quote to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new quote", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error adding quote";
                $this->addLogEntry("Failed to create a new quote - invalid data", "danger");
            }
        }
        $viewData['quote'] = $quote;
        $viewData['statuses'] = $quotes->getAllStatuses();
        $this->getView($viewData)->render();
    }

    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var QuotesModel $quotes */
            $quotes = $this->loadModel('Quotes');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                /** @var Quote $quote */
                $quote = $quotes->getById($id);
                if ($quote === null)
                {
                    $this->addLogEntry("Failed to delete quote - supplied ID is invalid", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        $this->redirect("/Quotes");
                    }
                }
                $result = $quotes->delete($quote);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Quote with ID " . $id . " delete successfully", "success");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(true, ['quote' => $quote->id]);
                    }
                    else
                    {
                        $this->redirect("/Quotes");
                    }
                }
                else
                {
                    $this->getLog()->newEntry("Failed to delete quote with ID " . $id . ": " . $result->getErrorString(), "database");
                    $this->addLogEntry("Failed to delete quote from the database. Check the errors log for further information, or contact your system administrator.", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        $this->redirect("/Quotes");
                    }
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->addLogEntry("Failed to delete quote - no ID supplied", "danger");
                if ($this->getRequest()->isAjax())
                {
                    $this->jsonResponse(false);
                }
                else
                {
                    $this->redirect("/Quotes");
                }
            }
        }
        $this->getView()->render();
    }

    public function Update($id)
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null)
        {
            $this->redirect("/Quotes");
        }
        if ($this->getRequest()->isAjax())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $quote->fromArray($data, "quote_");
            if ($quote->isValid())
            {
                $result = $this->getORM()->save($quote);
                if ($result->isSuccess())
                {
                    $quote->id = $result->getLastId();
                    $this->addLogEntry("Updated quote with ID: " . $quote->id, "success");
                    $this->jsonResponse(true);
                }
                else
                {
                    $viewData['error'] = "Error updating quote to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating quote in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update quote", "danger");
                    $this->jsonResponse(false);
                }
            }
            else
            {
                $viewData['error'] = "Error updating quote";
                $this->addLogEntry("Failed to update quote - invalid data", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['quote'] = $quote;
        $this->getView($viewData)->render();
    }

}