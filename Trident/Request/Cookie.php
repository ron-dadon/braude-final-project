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

namespace Trident\Request;

/**
 * Class Cookie
 *
 * A simple cookie related functions wrapper.
 *
 * @package Trident\Request
 */
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