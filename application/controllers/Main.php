<?php

namespace Application\Controllers;

use application\Entities\LogEntry;
use Application\Libraries\CUrl;
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

    public function Profile()
    {
        $user = $this->getLoggedUser();
        if ($this->getRequest()->isPost())
        {
            if ($this->getRequest()->getPost()->item('user_password') !== $this->getRequest()->getPost()->item('user_confirm_password'))
            {
                $viewData['error'] = "Can not update user profile. Passwords don't match.";
            }
            else
            {
                $oldPassword = '';
                $data = $this->getRequest()->getPost()->toArray();
                if ($this->getRequest()->getPost()->item('user_password') === '')
                {
                    unset($data['user_password']);
                    $oldPassword = $user->password;
                    $user->password = '123456';
                }
                $user->fromArray($data, "user_");
                if (!$user->isValid())
                {
                    $viewData['error'] = "Can not update user profile. The following fields are invalid:";
                    $user = $this->getLoggedUser();
                }
                else
                {
                    if ($this->getRequest()->getPost()->item('user_password') !== '')
                    {
                        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
                    }
                    else
                    {
                        $user->password = $oldPassword;
                    }
                    $result = $this->getORM()->save($user);
                    if ($result->isSuccess())
                    {
                        $this->addLogEntry("Successfully updated user profile", "success");
                        $viewData['success'] = "User updated successfully!";
                    }
                    else
                    {
                        $this->addLogEntry("Update of user profile failed", "danger");
                        $this->getLog()->newEntry($result->getErrorString(), "database");
                        $viewData['error'] = "Can not update user profile";
                    }
                }
            }
        }
        $viewData['user'] = $user;
        $this->getView($viewData)->render();
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
            $user->lastActive = date("Y-m-d H:i:s");
            $this->getORM()->save($user);
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