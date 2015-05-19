<?php

namespace Application\Controllers;

use Application\Entities\User;
use Application\Models\Logs;
use Application\Models\Users;

class Administration extends IacsBaseController
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        if (!$this->isUserLogged() || !$this->getLoggedUser()->admin)
        {
            $this->redirect("/Error");
        }
    }

    public function Index()
    {
        $this->getView()->render();
    }

    public function Log()
    {
        /** @var Logs $logs */
        $logs = $this->loadModel('Logs');
        $list = $logs->getAll();
        $viewData['entries'] = $list;
        $this->getView($viewData)->render();
    }

    public function Users()
    {
        /** @var Users $users */
        $users = $this->loadModel('Users');
        $list = $users->getAll();
        $viewData['users'] = $list;
        $this->getView($viewData)->render();
    }

    public function DeleteUser()
    {
        if ($this->getRequest()->isAjax())
        {
            /** @var Users $users */
            $users = $this->loadModel('Users');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                $user = $users->getById($id);
                if ($user === null)
                {
                    $this->jsonResponse(false);
                }
                $result = $users->delete($user);
                if ($result->isSuccess())
                {
                    $this->jsonResponse(true, ['user' => $user->firstName . ' ' . $user->lastName]);
                }
                else
                {
                    $this->jsonResponse(false, ['user' => $user->firstName . ' ' . $user->lastName]);
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->jsonResponse(false);
            }
        }
        $this->redirect("/Error");
    }

    public function AddUser()
    {
        $user = new User();
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $user->fromArray($data, "user_");
            if (!$user->isValid() || $user->password !== $this->getRequest()->getPost()->item('user_confirm_password'))
            {
                $viewData['error'] = "Can not add user. The following fields are invalid:";
            }
            else
            {
                $user->password = password_hash($user->password, PASSWORD_BCRYPT);
                $result = $this->getORM()->save($user);
                if ($result->isSuccess())
                {
                    $this->redirect("/Administration/Users");
                }
                else
                {
                    $viewData['error'] = "Can not add user. The following fields are invalid:";
                }
            }
        }
        $viewData['user'] = $user;
        $this->getView($viewData)->render();
    }

    public function UpdateUser($id)
    {

    }

    public function Settings()
    {
        if ($this->getRequest()->isAjax())
        {
            try
            {
                $securityAllowIdle = $this->getRequest()->getPost()->item('securityAllowIdle');
                if ($securityAllowIdle !== '0' && $securityAllowIdle !== '1')
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $securityIdleTime = $this->getRequest()->getPost()->item('securityIdleTime');
                if (!filter_var($securityIdleTime, FILTER_VALIDATE_INT) || ($securityIdleTime < 0 || $securityIdleTime > 120))
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $securityAllowReset = $this->getRequest()->getPost()->item('securityAllowReset');
                if ($securityAllowReset !== '0' && $securityAllowReset !== '1')
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $emailHost = $this->getRequest()->getPost()->item('emailHost');
                if (!preg_match('/^[a-z0-9A-Z\:\/\.\-]{0,}$/', $emailHost))
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $emailPort = $this->getRequest()->getPost()->item('emailPort');
                if (!filter_var($emailPort, FILTER_VALIDATE_INT) || ($emailPort < 0 || $emailPort > 65535))
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $emailSecurity = $this->getRequest()->getPost()->item('emailSecurity');
                if (array_search($emailSecurity, ['none', 'ssl', 'tls']) === false)
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $emailUser = $this->getRequest()->getPost()->item('emailUser');
                if (!preg_match('/^[a-zA-Z0-9\.\-\@\_]{0,}$/', $emailUser))
                {
                    $this->addLogEntry("Failed system settings update", "danger");
                    $this->jsonResponse(false);
                }
                $emailPassword = $this->getRequest()->getPost()->item('emailPassword');
                $this->getConfiguration()->set('user.security.allow-auto-logout', $securityAllowIdle === '1');
                $this->getConfiguration()->set('user.security.auto-logout-time', intval($securityIdleTime));
                $this->getConfiguration()->set('user.security.allow-password-reset', $securityAllowReset === '1');
                $this->getConfiguration()->set('user.email.host', $emailHost);
                $this->getConfiguration()->set('user.email.port', intval($emailPort));
                $this->getConfiguration()->set('user.email.security', $emailSecurity);
                $this->getConfiguration()->set('user.email.user', $emailUser);
                $this->getConfiguration()->set('user.email.password', stripslashes($emailPassword));
                $this->getConfiguration()->save(CONFIGURATION_FILE);
                $this->addLogEntry("Successful system settings update", "success");
                $this->jsonResponse(true);
            }
            catch (\Exception $e)
            {
                $this->addLogEntry("Failed system settings update", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['security-idle-logout'] = $this->getConfiguration()->item('user.security.allow-auto-logout');
        $viewData['security-idle-logout-time'] = $this->getConfiguration()->item('user.security.auto-logout-time');
        $viewData['security-password-reset'] = $this->getConfiguration()->item('user.security.allow-password-reset');
        $viewData['email-host'] = $this->getConfiguration()->item('user.email.host');
        $viewData['email-port'] = $this->getConfiguration()->item('user.email.port');
        $viewData['email-security'] = $this->getConfiguration()->item('user.email.security');
        $viewData['email-user'] = $this->getConfiguration()->item('user.email.user');
        $viewData['email-password'] = $this->getConfiguration()->item('user.email.password');
        $this->getView($viewData)->render();
    }

}