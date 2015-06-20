<?php

namespace Application\Controllers;

use Application\Entities\Quote;
use Application\Entities\QuoteProduct;
use Application\Models\Clients;
use Application\Models\Products;
use Application\Models\Quotes as QuotesModel;
use Trident\Database\Query;

/**
 * Class Quotes
 *
 * This class provides the logic layer for the quotes data.
 *
 * @package Application\Controllers
 */
class Quotes extends IacsBaseController
{

    /**
     * Show all quotes.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Index()
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel("Quotes");
        $viewData['quotes'] = $quotes->getAll();
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

    /**
     * Add a new quote.
     * Quote information must be passed via POST.
     * An optional client-id can be supplied to auto-set the client.
     *
     * @param null|int|string $clientId Client ID.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     * @throws \Trident\Exceptions\MySqlException
     */
    public function Add($clientId = null)
    {
        $quote = new Quote();
        /** @var Clients $clients */
        $clients = $this->loadModel("Clients");
        /** @var Products $products */
        $products = $this->loadModel("Products");
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
            $this->getMysql()->beginTransaction();
            $data = $this->getRequest()->getPost()->toArray();
            $quote->fromArray($data, "quote_");
            $quote->products = new QuoteProduct();
            if ($quote->isValid())
            {
                $result = $this->getORM()->save($quote);
                if ($result->isSuccess())
                {
                    $quote->id = $result->getLastId();
                    $productsList = $this->getRequest()->getPost()->toArray()['quote_products'];
                    $quantities = $this->getRequest()->getPost()->toArray()['product_quantity'];
                    $query = 'INSERT INTO quote_products VALUES ';
                    $params = [];
                    foreach ($productsList as $key => $product) {
                        $query .= " ('{$quote->id}', :prod{$key}, :q{$key}),";
                        $params[":prod{$key}"] = $product;
                        $params[":q{$key}"] = $quantities[$key];
                    }
                    $query = rtrim($query, ',');
                    $query = new Query($query, $params);
                    $result = $this->getMysql()->executeQuery($query);
                    if ($result->isSuccess()) {
                        $this->getMysql()->commit();
                        $this->addLogEntry("Created quote with ID: " . $quote->id, "success");
                        $this->setSessionAlertMessage("Quote number {$quote->id} created!", "success");
                        $this->redirect('/Quotes/Show/' . $quote->id);
                    } else {
                        $viewData['error'] = "Error adding quote to the database. Check the errors log for further information, or contact your system administrator.";
                        $this->getLog()->newEntry("Error adding quote to database: " . $result->getErrorString(), "Database");
                        $this->addLogEntry("Failed to create a new quote", "danger");
                    }
                }
                else
                {
                    $this->getMysql()->rollBack();
                    $viewData['error'] = "Error adding quote to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding quote to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new quote", "danger");
                }
            }
            else
            {
                $this->getMysql()->rollBack();
                $viewData['error'] = "Error adding quote";
                $this->addLogEntry("Failed to create a new quote - invalid data", "danger");
            }
        }
        if ($quote->client !== null) {
            $quote->client = $clients->getById($quote->client);
        }
        $viewData['quote'] = $quote;
        $viewData['statuses'] = $quotes->getAllStatuses();
        $viewData['clients'] = $clients->getAll();
        $viewData['products'] = $products->getAll();
        $viewData['tax'] = $this->getConfiguration()->item('user.general.tax');
        $this->getView($viewData)->render();
    }

    /**
     * Delete a quote.
     * Quote ID for delete must be supplied via POST delete_id.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
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
                if ($quote->status->id === 5)
                {
                    $this->addLogEntry("Failed to delete quote - quote is invoiced", "danger");
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

    /**
     * Update quote.
     * Quote updated information must be passed via POST.
     *
     * @param string|int $id Quote ID.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     * @throws \Trident\Exceptions\MySqlException
     */
    public function Update($id)
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null)
        {
            $this->redirect("/Quotes");
        }
        $quote->status = $quote->status->id;
        $quote->date = substr($quote->date, 0, 10);
        /** @var Clients $clients */
        $clients = $this->loadModel("Clients");
        /** @var Products $products */
        $products = $this->loadModel("Products");
        if ($this->getRequest()->isPost())
        {
            $this->getMysql()->beginTransaction();
            $data = $this->getRequest()->getPost()->toArray();
            $quote->fromArray($data, "quote_");
            $quote->products = new QuoteProduct();
            if ($quote->isValid())
            {
                $quote->status = 1;
                $result = $this->getORM()->save($quote);
                if ($result->isSuccess())
                {
                    $productsList = $this->getRequest()->getPost()->toArray()['quote_products'];
                    $quantities = $this->getRequest()->getPost()->toArray()['product_quantity'];
                    $query = new Query('DELETE FROM quote_products WHERE quote_product_quote = :id', [':id' => $quote->id]);
                    if (!$this->getMysql()->executeQuery($query)->isSuccess()) {
                        $this->getMysql()->rollBack();
                        $viewData['error'] = "Error updating quote to the database. Check the errors log for further information, or contact your system administrator.";
                        $this->getLog()->newEntry("Error updating quote in database: " . $result->getErrorString(), "Database");
                        $this->addLogEntry("Failed to update quote with ID: {$quote->id}", "danger");
                    } else {
                        $query = 'INSERT INTO quote_products VALUES ';
                        $params = [];
                        foreach ($productsList as $key => $product) {
                            $query .= " ('{$quote->id}', :prod{$key}, :q{$key}),";
                            $params[":prod{$key}"] = $product;
                            $params[":q{$key}"] = $quantities[$key];
                        }
                        $query = rtrim($query, ',');
                        $query = new Query($query, $params);
                        $result = $this->getMysql()->executeQuery($query);
                        if ($result->isSuccess()) {
                            $this->getMysql()->commit();
                            $this->addLogEntry("Updated quote with ID: " . $quote->id, "success");
                            $viewData['success'] = "Quote updated successfully!";
                        } else {
                            $viewData['error'] = "Error updating quote to the database. Check the errors log for further information, or contact your system administrator.";
                            $this->getLog()->newEntry("Error updating quote in database: " . $result->getErrorString(), "Database");
                            $this->addLogEntry("Failed to update quote with ID: {$quote->id}", "danger");
                        }
                    }
                }
                else
                {
                    $this->getMysql()->rollBack();
                    $viewData['error'] = "Error updating quote to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating quote in database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update quote with ID: {$quote->id}", "danger");
                }
            }
            else
            {
                $this->getMysql()->rollBack();
                $errors = $quote->getErrors();
                $errors = implode('</li><li>', $errors);
                $viewData['error'] = "Error updating quote<br><ul><li>{$errors}</li></ul>";
                $this->addLogEntry("Failed to update quote with ID: {$quote->id}", "danger");
            }
        }
        if ($quote->client !== null) {
            $quote->client = $clients->getById($quote->client);
        }
        $quote = $quotes->getById($id);
        if ($quote === null)
        {
            $this->redirect("/Quotes");
        }
        $viewData['quote'] = $quote;
        $viewData['statuses'] = $quotes->getAllStatuses();
        $viewData['clients'] = $clients->getAll();
        $viewData['products'] = $products->getAll();
        $viewData['tax'] = $this->getConfiguration()->item('user.general.tax');
        $this->getView($viewData)->render();
    }

    /**
     * Show extended quote information.
     *
     * @param string|int $id Quote ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Show($id)
    {
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null) {
            $this->setSessionAlertMessage("Can't show quote with ID " . htmlspecialchars($id) . ". Quote doesn't exists.", "error");
            $this->redirect('/Quotes');
        }
        $viewData['quote'] = $quote;
        $this->getView($viewData)->render();
    }

    /**
     * Print a quote.
     *
     * @param string|int $id Quote ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function PrintQuote($id)
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null) {
            $this->setSessionAlertMessage("Can't print quote with ID " . htmlspecialchars($id) . ". Quote doesn't exists.", "error");
            $this->redirect('/Quotes');
        }
        $viewData['quote'] = $quote;
        $viewData['title'] = "IACS Quote No. " . str_pad($quote->id, 8, '0', STR_PAD_LEFT);
        $this->getView($viewData)->render();
    }

    /**
     * Mail a quote to the client's email address.
     *
     * @param string|int $id Quote ID.
     *
     * @throws \Trident\Exceptions\LibraryNotFoundException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function MailQuote($id)
    {
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null) {
            $this->setSessionAlertMessage("Can't mail quote with ID " . htmlspecialchars($id) . ". Quote doesn't exists.", "error");
            $this->redirect('/Quotes');
        }
        if (!trim($quote->client->email)) {
            $this->setSessionAlertMessage("Can't mail quote with ID " . htmlspecialchars($id) . ". Client doesn't have an e-mail address.", "error");
            $this->redirect('/Quotes');
        }
        $this->getLibraries()->load('Mailer');
        /** @var \Application\Libraries\Mailer $mailer */
        $mailer = $this->getLibraries()->Mailer;
        $altBody = $body = "IACS Quote";
        if ($mailer->send([$quote->client->email => $quote->client->name], 'Quote from IACS', $body, $altBody,[],[],[],['display_name' => 'IACS']))
        {
            $quote->status = 2;
            $this->getORM()->save($quote);
            echo '1';
        } else {
            echo $mailer->getError();
        }
    }

    /**
     * Mark a quote status.
     *
     * @param string $type Status type.
     * @param string|int $id Quote ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Mark($type, $id)
    {
        if ($type !== 'Decline' && $type !== 'Approve' && $type !== 'Draft') {
            $this->setSessionAlertMessage("Can't mark quote. Invalid mark type.", "error");
            $this->redirect('/Quotes');
        }
        /** @var QuotesModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quote = $quotes->getById($id);
        if ($quote === null) {
            $this->setSessionAlertMessage("Can't mark quote with ID " . htmlspecialchars($id) . ". Quote doesn't exists.", "error");
            $this->redirect('/Quotes');
        }
        if ($quote->status->id == 5) {
            $this->setSessionAlertMessage("Can't mark quote with ID " . htmlspecialchars($id) . ". Quote already invoiced.", "error");
            $this->redirect('/Quotes');
        }
        $quote->status = $type === 'Decline' ? 3 : ($type === 'Approve' ? 4 : 1);
        if ($this->getORM()->save($quote)->isSuccess()) {
            $this->setSessionAlertMessage("Quote " . str_pad($quote->id, 8, '0', STR_PAD_LEFT) . " marked as {$type}", "success");
            $this->redirect('/Quotes');
        } else {
            $this->setSessionAlertMessage("Can't mark quote.", "error");
            $this->redirect('/Quotes');
        }
    }

}