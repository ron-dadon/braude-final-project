<?php

/**
 * Class Validation_Library
 *
 * A wrapper for basic validation functions.
 */
class Validation_Library extends Library
{

    /**
     * Check if a variable contains a valid number
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is a number, false otherwise
     */
    public function isNumber($var)
    {
        $pattern = '/^(([-])?[\d]+([\.][\d]+)?)$/';
        return preg_match($pattern, $var) === 1;
    }

    /**
     * Check if a variable contain an integer
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is an integer, false otherwise
     */
    public function isInteger($var)
    {
        $pattern = '/^([\d]+)$/';
        return preg_match($pattern, $var) === 1;
    }

    /**
     * Check if a variable contain a float
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is a float, false otherwise
     */
    public function isFloat($var)
    {
        return filter_var($var, FILTER_VALIDATE_FLOAT);
    }

    /**
     * Check if a variable is a boolean value
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is a boolean, false otherwise
     */
    public function isBoolean($var)
    {
        return filter_var($var, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Check if a variable is a valid email address
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is an email address, false otherwise
     */
    public function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check if a variable is a valid ip address
     *
     * @param mixed $var variable
     *
     * @return bool true if variable is a valid ip address, false otherwise
     */
    public function isIp($var)
    {
        $pattern = '/^([\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3})$/';
        return filter_var($var, FILTER_VALIDATE_IP) && (preg_match($pattern, $var) === 1);
    }

    /**
     * Check if a variable matches regular expression pattern
     *
     * @param mixed  $var   variable
     * @param string $regex regular expression pattern
     *
     * @return bool true if variable matches the pattern, false otherwise
     */
    public function isMatchRegex($var, $regex)
    {
        return preg_match($regex, $var) === 1;
    }

    /**
     * Check if a variable is within a list of values
     *
     * @param mixed $var  variable
     * @param array $list list of values
     *
     * @return bool true if variable matches at least one of the values, false otherwise
     */
    public function isInList($var, $list = [])
    {
        foreach ($list as $item)
        {
            if ($var == $item)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if a numeric variable is between 2 values
     *
     * @param mixed            $var variable
     * @param int|float|double $min minimum value
     * @param int|float|double $max maximum value
     *
     * @return bool true if variable is a number and is between $min and $max, false otherwise
     */
    public function isBetween($var, $min, $max)
    {
        return $this->isAtLeast($var, $min) && $this->isAtMost($var, $max);
    }

    /**
     * Check if a numeric variable is at least a minimum value
     *
     * @param mixed            $var variable
     * @param int|float|double $min minimum value
     *
     * @return bool true if variable is a number and is at least $min, false otherwise
     */
    public function isAtLeast($var, $min)
    {
        return $this->isNumber($var) && $var >= $min;
    }

    /**
     * Check if a numeric variable is at most a maximum value
     *
     * @param mixed            $var variable
     * @param int|float|double $max maximum value
     *
     * @return bool true if variable is a number and is at most $max, false otherwise
     */
    public function isAtMost($var, $max)
    {
        return $this->isNumber($var) && $var <= $max;
    }

    /**
     * Check if a string variable length is between 2 values
     *
     * @param string $var variable
     * @param int    $min minimum length
     * @param int    $max maximum length
     *
     * @return bool true if variable is a string and is length is between $min and $max, false otherwise
     */
    public function isBetweenLength($var, $min, $max)
    {
        return $this->isAtLeastLength($var, $min) && $this->isAtMostLength($var, $max);
    }

    /**
     * Check if a length of a string variable is at least a minimum value
     *
     * @param string $var variable
     * @param int    $min minimum length
     *
     * @return bool true if variable is a string and is length is at least $min, false otherwise
     */
    public function isAtLeastLength($var, $min)
    {
        return strlen($var) >= $min;
    }

    /**
     * Check if a length of a string variable is at most a maximum value
     *
     * @param string $var variable
     * @param int    $max maximum value
     *
     * @return bool true if variable is a string and is length is at most $max, false otherwise
     */
    public function isAtMostLength($var, $max)
    {
        return strlen($var) <= $max;
    }
}