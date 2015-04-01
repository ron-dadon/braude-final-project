<?php

/**
 * Class Security_Library
 *
 * A wrapper for basic security functions.
 */
class Security_Library extends Library
{

    private $_encryption_key;

    /**
     * Creates a random string
     *
     * @param int $length size of salt
     *
     * @return string random salt
     */
    public function create_salt($length = 32)
    {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }

    /**
     * Wrapper for hash() function
     *
     * @param string $algorithm hashing algorithm
     * @param string $value     value to hash
     * @param string $salt      salt for hash
     *
     * @return string hashed string
     */
    public function hash($algorithm, $value, $salt)
    {
        return hash($algorithm, $value . $salt);
    }

    /**
     * Encrypt a string
     *
     * @param string $value unencrypted string
     *
     * @return string encrypted string
     */
    public function encrypt($value)
    {
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_encryption_key, $value, MCRYPT_MODE_ECB);
    }

    /**
     * Decode encrypted string
     *
     * @param string $value encrypted string
     *
     * @return string decoded string
     */
    public function decrypt($value)
    {
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_encryption_key, $value, MCRYPT_MODE_ECB);
    }

    /**
     * Create a random string token to help prevent csrf
     * Alias of create_salt for better readability
     *
     * @param int $length length of random string
     *
     * @return string random string
     */
    public function create_csrf_token($length = 16)
    {
        return $this->create_salt($length);
    }

    /**
     * Set encryption and decryption key
     *
     * @param string $key
     */
    public function set_encryption_key($key)
    {
        $this->_encryption_key = $key;
    }

    /**
     * Wrapper for filter_var() function
     *
     * @param mixed $var    variable
     * @param int   $filter filter constants
     *
     * @return mixed sanitized variable
     */
    public function sanitize($var, $filter)
    {
        return filter_var($var, $filter);
    }
}