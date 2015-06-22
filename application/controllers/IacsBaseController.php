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
use Application\Libraries\CUrl;
use Trident\MVC\AbstractController;
use Trident\Exceptions\ViewNotFoundException;
use Trident\MVC\AbstractView;
use Application\Entities\User;

/**
 * Class IacsBaseController
 *
 * This abstract class extends the base framework abstract controller and
 * adds more application wide functionality required by most of the application controllers.
 *
 * All application controllers should extend from this class,
 * not from the base framework abstract controller.
 *
 * @package Application\Controllers
 */
abstract class IacsBaseController extends AbstractController
{

    /**
     * Logs instance.
     *
     * @var \Application\Models\Logs
     */
    private $logs;

    /**
     * Create a new instance.
     * Update logged user information if one is present.
     *
     * @param \Trident\System\Configuration $configuration
     * @param \Trident\System\Log           $log
     * @param \Trident\System\Request       $request
     * @param \Trident\System\Session       $session
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    function __construct($configuration, $log, $request, $session)
    {
        parent::__construct($configuration, $log, $request, $session);
        $this->loadMySql();
        $this->loadORM();
        $this->logs = $this->loadModel('Logs');
        try
        {
            /** @var User $user */
            $user = unserialize($this->getSession()->item('iacs-logged-user'));
            $autoLogout = $this->getConfiguration()->item('user.security.allow-auto-logout');
            $idleTime = $this->getConfiguration()->item('user.security.auto-logout-time');
            $lastActive = \DateTime::createFromFormat("Y-m-d H:i:s", $user->lastActive);
            $now = new \DateTime();
            if ($autoLogout && ($now->diff($lastActive, true)->i > $idleTime))
            {
                $this->getSession()->destroy();
                $this->redirect("/login");
            }
            $user->lastActive = $now->format('Y-m-d H:i:s');
            $result = $this->getORM()->save($user);
            if (!$result->isSuccess())
            {
                $this->getLog()->newEntry($result->getErrorString(), "database");
                $this->redirect("/Error");
            }
        }
        catch (\Exception $e)
        {
            $this->getLog()->newEntry($e->getMessage(), "general");
        }
    }

    /**
     * Load view instance.
     * If $view is not specified, loads the view according to the calling callable.
     *
     * @param array $viewData View data array.
     * @param null  $viewName View name.
     *
     * @throws ViewNotFoundException
     * @return AbstractView View instance.
     */
    protected function getView($viewData = [], $viewName = null)
    {
        $reflect = new \ReflectionClass($this);
        $class = $reflect->getShortName();
        $viewData['currentMenuItem'] = $class;
        $viewData['exchange-rate'] = $this->getUSDRate();
        try
        {
            $user = $this->getSession()->item('iacs-logged-user');
        }
        catch (\InvalidArgumentException $e)
        {
            $user = null;
        }
        if (isset($user))
        {
            $viewData['currentUser'] = unserialize($user);
        }
        if (is_null($viewName))
        {
            $viewName = debug_backtrace()[1]['function'];
            $viewName = "$class\\$viewName";
        }
		$viewData['viewName'] = $viewName;
        return parent::getView($viewData, $viewName);
    }

    /**
     * Check if user is logged in.
     *
     * @return bool True if logged in, false otherwise.
     */
    protected function isUserLogged()
    {
        try
        {
            $this->getSession()->item('iacs-logged-user');
            return true;
        }
        catch (\InvalidArgumentException $e)
        {
            return false;
        }
    }

    /**
     * Get the logged user.
     *
     * @return User The loggged user entity.
     */
    protected function getLoggedUser()
    {
        /** @var User $user */
        $user = unserialize($this->getSession()->item('iacs-logged-user'));
        return $user;
    }

    /**
     * Create a JSON response.
     * JSON object will contain a result boolean property,
     * and a details array property.
     * Script will exit at the end of this function.
     *
     * @param bool $result
     * @param array $details
     */
    protected function jsonResponse($result, $details = [])
    {
        $json = ['result' => $result, 'details' => $details];
        echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit();
    }

    /**
     * Add a log entry to the database log.
     *
     * @param string $entry Entry
     * @param string $level Level (info, success, danger or warning)
     */
    protected function addLogEntry($entry, $level = "info")
    {
        $logEntry = new LogEntry();
        $logEntry->browser = $this->getRequest()->getBrowser() . '(' . $this->getRequest()->getBrowserVersion() . ')';
        $logEntry->platform = $this->getRequest()->getPlatform();
        $logEntry->ip = $this->getRequest()->getIp();
        /** @var User $user */
        $user = unserialize($this->getSession()->item('iacs-logged-user'));
        $logEntry->user = $user->id;
        $logEntry->entry = $entry;
        $logEntry->level = $level;
        $this->getORM()->save($logEntry);
    }

    /**
     * Set a session alert message to be displayed after a redirection.
     *
     * @param string $message Message text.
     * @param string $type Message type (success, error)
     */
    protected function setSessionAlertMessage($message, $type = "success")
    {
        $_SESSION['alert-message'] = ['type' => $type, 'message' => $message];
    }

    /**
     * Get the stored session message and remove it from the session.
     * If no message exists - return null.
     *
     * @return array|null
     */
    protected function pullSessionAlertMessage()
    {
        if (isset($_SESSION['alert-message']))
        {
            $message = $_SESSION['alert-message'];
            unset($_SESSION['alert-message']);
            return $message;
        }
        return null;
    }

    /**
     * Get the USD to NIS convert ratio based of the configuration api string.
     * The api must return a valid XML instance, and contain the rate in a <rate> tag.
     * If no access is available, the last retrieved rate will be used.
     *
     * @return string|float USD to NIS rate.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\JsonParseException
     */
    protected function getUSDRate()
    {
        $curl = new CUrl($this->getConfiguration(), $this->getLog(), $this->getRequest(), $this->getSession());
        $data = $curl->getUrl($this->getConfiguration()->item('api.currency'));
        preg_match('/\<rate\>([0-9\.]+)\<\/rate\>/i', $data, $rate);
        if (isset($rate[1])) {
            $this->getConfiguration()->set('api.last', $rate[1]);
            $this->getConfiguration()->save(CONFIGURATION_FILE);
            return $rate[1];
        }
        return $this->getConfiguration()->item('api.last');
    }
}