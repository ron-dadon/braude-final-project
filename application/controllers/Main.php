<?php

namespace Application\Controllers;

use application\Entities\LogEntry;
use Application\Models\Users;
use Application\Entities\User;
use Application\Models\Logs;

class Main extends IacsBaseController
{

    public function Index()
    {
        if (!$this->isUserLogged())
        {
            $this->redirect("/Login");
        }
        $this->getView()->render();
    }

    public function Settings()
    {
        if (!$this->isUserLogged())
        {
            $this->redirect("/Login");
        }
        $this->getView()->render();
    }

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
            $this->getSession()->set('iacs-logged-user', serialize($user));
            $this->jsonResponse(true);
        }
        $this->getView()->render();
    }

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