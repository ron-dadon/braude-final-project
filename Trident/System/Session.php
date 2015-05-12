<?php

namespace Trident\System;

/**
 * Class Session
 *
 * @package Trident\System
 */
class Session
{

    /**
     * Initialize session.
     */
    function __construct()
    {
        session_start();
    }

    /**
     * Get a session item.
     *
     * @param string $key Session item key.
     *
     * @return mixed Session item.
     */
    public function item($key)
    {
        if (!isset($_SESSION[$key]))
        {
            throw new \InvalidArgumentException("Session key `$key` doesn't exists");
        }
        return $_SESSION[$key];
    }

    /**
     * Set a session item.
     *
     * @param string $key   Session item key.
     * @param mixed  $value Session item.
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Clear a session item.
     *
     * @param string $key Session item key.
     */
    public function clear($key)
    {
        if (!isset($_SESSION[$key]))
        {
            throw new \InvalidArgumentException("Session key `$key` doesn't exists");
        }
        unset($_SESSION[$key]);
    }

    /**
     * Get a session item and clear it.
     *
     * @param string $key Session item key.
     *
     * @return mixed Session item.
     */
    public function pull($key)
    {
        $value = $this->item($key);
        $this->clear($key);
        return $value;
    }

    /**
     * Clear all session items.
     */
    public function truncate()
    {
        session_unset();
    }

    /**
     * Destroy the session and remove it.
     */
    public function destroy()
    {
        $this->truncate();
        session_destroy();
        if (ini_get("session.use_cookies"))
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],
                      $params["httponly"]
            );
        }
    }
} 