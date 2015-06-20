<?php

namespace Application\Controllers;

use application\Entities\LogEntry;
use Application\Models\Users;
use Application\Entities\User;
use Application\Models\Logs;
use Application\Models\Quotes as QuoteModel;
use Application\Models\Invoices as InvoicesModel;

/**
 * Class Main
 *
 * This class provides the logic layer for the main actions.
 *
 * @package Application\Controllers
 */
class Main extends IacsBaseController
{

    /**
     * Show system home screen.
     * Display important information for the user.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Index()
    {
        if (!$this->isUserLogged())
        {
            $this->redirect("/Login");
        }
        /** @var QuoteModel $quotes */
        $quotes = $this->loadModel('Quotes');
        $quotes->updateExpired();
        /** @var InvoicesModel $invoices */
        $invoices = $this->loadModel('Invoices');
        $viewData['usd-rate'] = $this->getUSDRate();
        $viewData['clients-count'] = $this->loadModel('Clients')->count();
        $viewData['products-count'] = $this->loadModel('Products')->count();
        $viewData['quotes-count'] = $quotes->count();
        $viewData['quotes'] = $quotes->getAllSentOrDraft();
        $viewData['invoices'] = $invoices->getUnpaid();
        $viewData['invoices-count'] = $invoices->count();
        $viewData['quotes-months'] = $quotes->getQuotesByMonth();
        $viewData['top-selling-products'] = $quotes->getTopSellingProducts();
        $viewData['invoices-months'] = $invoices->getByMonth();
        $viewData['income-months'] = $invoices->getIncomeByMonth();
        $this->getView($viewData)->render();
    }

    /**
     * Show the login screen and handle login request.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Login()
    {
        if ($this->isUserLogged())
        {
            $this->redirect("/");
        }
        if ($this->getRequest()->isAjax())
        {
            /** @var Logs $log */
            $log = $this->loadModel('Logs');
            $logEntry = new LogEntry();
            $logEntry->browser = $this->getRequest()->getBrowser() . '(' . $this->getRequest()->getBrowserVersion() . ')';
            $logEntry->platform = $this->getRequest()->getPlatform();
            $logEntry->ip = $this->getRequest()->getIp();
            $logEntry->user = null;
            list($email, $password) = [$this->getRequest()->getPost()->item('user_email'),
                                       $this->getRequest()->getPost()->item('user_password')];
            /** @var Users $model */
            $model = $this->loadModel('Users');
            /** @var User[]|User|null $user */
            $user = $model->search("user_email = ?", [$email]);
            if ($user === null || count($user) !== 1)
            {
                $logEntry->level = 'danger';
                $logEntry->entry = "Failed login attempt with credentials $email, $password";
                $log->saveLogEntry($logEntry);
                $this->jsonResponse(false);
            }
            $user = $user[0];
            if (!password_verify($password, $user->password))
            {
                $logEntry->level = 'danger';
                $logEntry->entry = "Failed login attempt with credentials $email, $password";
                $log->saveLogEntry($logEntry);
                $this->jsonResponse(false);
            }
            $logEntry->user = $user->id;
            $logEntry->level = 'success';
            $logEntry->entry = "User logged in successfully";
            $log->saveLogEntry($logEntry);
            $user->lastActive = date("Y-m-d H:i:s");
            $this->getORM()->save($user);
            $this->getSession()->set('iacs-logged-user', serialize($user));
            $this->jsonResponse(true);
        }
        $this->getView()->render();
    }

    /**
     * Logout the user.
     * Return OK for AJAX request.
     * Redirect to base public path for non-ajax request.
     */
    public function Logout()
    {
        $this->getSession()->destroy();
        if (!$this->getRequest()->isAjax())
        {
            $this->redirect("/");
        }
        else
        {
            echo "OK";
        }
    }

} 