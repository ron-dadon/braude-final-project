<?php

namespace Application\Controllers;

use application\Entities\LogEntry;
use Application\Models\Users;
use Application\Entities\User;
use Application\Models\Logs;

class Profile extends IacsBaseController
{

    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        if (!$this->isUserLogged())
        {
            $this->redirect("/Error");
        }
    }

    public function Index()
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
                if (isset($data['user_admin']))
                {
                    unset($data['user_admin']);
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
                        $viewData['success'] = "User profile updated successfully!";
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

} 