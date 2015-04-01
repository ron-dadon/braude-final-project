<?php

/**
 * Class Session
 */
class Session extends Global_Array
{

    /**
     * Session constructor
     *
     * Build sanitized session data
     */
    function __construct()
    {
        if (!isset($_SESSION))
        {
            session_start();
        }
        $this->_data = $this->sanitize($_SESSION);
    }

    /**
     * Set session variable
     *
     * @param string $key   variable key
     * @param string $value variable value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        $this->_data[$key] = $value;
    }

    /**
     * Clears session variable
     *
     * @param string $key variable key
     *
     * @throws Trident_Exception
     */
    public function clear($key)
    {
        if (isset($this->_data[$key]) && isset($_SESSION[$key]))
        {
            unset($this->_data[$key]);
            unset($_SESSION[$key]);
        }
        else
        {
            throw new Trident_Exception("Session: key $key doesn't exists");
        }
    }

    /**
     * Destroy session
     */
    public function destroy()
    {
        $this->_data = [];
        session_destroy();
        if (ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }
}