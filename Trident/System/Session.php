<?php
/**
 * Trident Framework - PHP MVC Framework
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 Ron Dadon
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Trident\System;

/**
 * Class Session
 *
 * Wrapper for session related operations.
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