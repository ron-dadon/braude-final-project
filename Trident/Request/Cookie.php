<?php

namespace Trident\Request;

class Cookie
{

    /**
     * Get cookie item.
     *
     * @param string $key Cookie item key.
     *
     * @return string Cookie item value.
     */
    public function item($key)
    {
        if (!isset($_COOKIE[$key]))
        {
            throw new \InvalidArgumentException();
        }
        return $_COOKIE[$key];
    }

    /**
     * Set cookie item.
     *
     * @param string                $key      Cookie item key.
     * @param string|float|int|bool $value    Cookie item value.
     * @param int|string            $expire   Cookie item expiration time (use m/h/d suffix for minutes, hours and day
     *                                        respectably).
     * @param null                  $path     Cookie path.
     * @param null                  $domain   Cookie domain.
     * @param null                  $secure   Only use on secure connections (https).
     * @param bool                  $httpOnly Disallow javascript access to the cookie.
     */
    public function set($key, $value, $expire = 0, $path = null, $domain = null, $secure = null, $httpOnly = true)
    {
        if ($expire !== 0)
        {
            if (preg_match('/^[0-9]+m$/', $value))
            {
                $expire = time() + 60 * $expire;
            }
            if (preg_match('/^[0-9]+h$/', $value))
            {
                $expire = time() + 60 * 60 * $expire;
            }
            if (preg_match('/^[0-9]+d$/', $value))
            {
                $expire = time() + 60 * 60 * 24 * $expire;
            }
        }
        setcookie($key, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    /**
     * Clear cookie item.
     *
     * @param string $key Cookie item key.
     */
    public function clear($key)
    {
        if (!isset($_COOKIE[$key]))
        {
            throw new \InvalidArgumentException();
        }
        setcookie($key, '', time() - 60 * 60);
    }
} 