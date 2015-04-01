<?php

/**
 * Class Cookie
 */
class Cookie extends Global_Array
{

    /**
     * Cookie constructor
     *
     * Build sanitized cookie data
     */
    function __construct()
    {
        $this->_data = $this->sanitize($_COOKIE);
    }

    /**
     * Set cookie
     *
     * @param string      $key    cookie key
     * @param string      $value  cookie value
     * @param int|null    $life   cookie life (in seconds)
     * @param string|null $path   cookie path
     * @param string|null $domain cookie domain
     * @param bool|null   $secure is cookie secure only
     *
     * @return void
     */
    public function set($key, $value, $life = null, $path = null, $domain = null, $secure = null)
    {
        setcookie($key, $value, $life, $path, $domain, $secure, true);
        $this->_data[$key] = $value;
    }

    /**
     * Clears cookie
     *
     * @param string $key cookie key
     *
     * @return void
     * @throws Trident_Exception
     */
    public function clear($key)
    {
        if (isset($this->_data[$key]))
        {
            $this->set($key, '', time() - 3600);
            unset($this->_data[$key]);
        }
        else
        {
            throw new Trident_Exception("Cookie: key $key doesn't exists");
        }
    }
}