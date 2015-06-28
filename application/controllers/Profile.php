<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Controllers;

use Application\Entities\LogEntry;
use Application\Models\Users;
use Application\Entities\User;
use Application\Models\Logs;

/**
 * Class Profile
 *
 * This class provides the logic layer for the profile.
 *
 * @package Application\Controllers
 */
class Profile extends IacsBaseController
{

    /**
     * Create a new instance.
     *
     * Allow only logged in users to access this controller.
     * If a un-logged user is trying to access the controller,
     * redirect him the the error screen.
     *
     * @param \Trident\System\Configuration $configuration
     * @param \Trident\System\Log           $log
     * @param \Trident\System\Request       $request
     * @param \Trident\System\Session       $session
     */
    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        if (!$this->isUserLogged())
        {
            $this->redirect("/Error");
        }
    }

    /**
     * Show the profile index view.
     * If the users send a request to change it's password, handle the password change.
     *
     * @throws \Trident\Exceptions\IOException
     */
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
                $password = $this->getRequest()->getPost()->item('user_password');
                if ($password !== '')
                {
                    $user->password = $password;
                    if (!$user->isValid())
                    {
                        $viewData['error'] = "Can not update user profile. The following fields are invalid:";
                        $user = $this->getLoggedUser();
                    }
                    else
                    {
                        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
                        $result = $this->getORM()->save($user);
                        if ($result->isSuccess())
                        {
                            $this->addLogEntry("Successfully updated user profile", "success");
                            $this->getSession()->set('iacs-logged-user', serialize($user));
                            $this->setSessionAlertMessage("User profile updated successfully!");
                            $this->redirect('/Profile');
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
        }
        $viewData['user'] = $user;
        $this->getView($viewData)->render();
    }

} 