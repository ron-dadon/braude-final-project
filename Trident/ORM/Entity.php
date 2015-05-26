<?php


namespace Trident\ORM;

abstract class Entity
{

    /**
     * Database table name.
     *
     * @var string
     */
    protected $_table;

    /**
     * Database field prefix.
     *
     * @var string
     */
    protected $_prefix;

    /**
     * Primary key property name.
     *
     * @var string
     */
    protected $_primary;

    /**
     * Errors array.
     *
     * @var array
     */
    protected $_errors;

    /**
     * Return primary key value when entity is converted to string.
     *
     * @return string
     */
    function __toString()
    {
        $primary = $this->_primary;
        return $this->$primary;
    }

    /**
     * Select properties to be serialized.
     *
     * @return array Properties array.
     */
    function __sleep()
    {
        return array_keys(get_object_vars($this));
    }

    /**
     * Get primary property name.
     *
     * @return string
     */
    public function getPrimary()
    {
        return $this->_primary;
    }

    /**
     * Get table name.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Get fields prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }

    /**
     * Get entity errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    protected function setError($field, $error)
    {
        $fields = array_keys($this->toArray());
        if (array_search($this->getPrefix() . $field, $fields) === false)
        {
            throw new \InvalidArgumentException("Can't set error to field $field. Field doesn't exists in entity");
        }
        $this->_errors[$field] = $error;
    }

    /**
     * Convert object to an associative array.
     *
     * @return array
     */
    public function toArray()
    {
        $properties = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $fields = array_map(function (\ReflectionProperty $item)
            {
                return $item->getName();
            }, $properties);
        $values = array_map(function ($item)
            {
                return $this->$item;
            }, $fields);
        $fields = array_map(function ($item)
            {
                return $this->_prefix . $item;
            }, $fields);
        return array_combine($fields, $values);
    }

    /**
     * Fill entity properties from an associative array.
     * Array keys must contain the field prefix.
     *
     * @param array $array Data array.
     * @param string $keyPrefix Key prefix.
     */
    public function fromArray($array, $keyPrefix = "")
    {
        if (!is_array($array))
        {
            throw new \InvalidArgumentException("Entity from array method requires an array as argument");
        }
        $fields = array_keys($this->toArray());
        foreach ($fields as $field)
        {
            if (isset($array[$field]))
            {
                $shortField = str_replace($keyPrefix, "", $field);
                $this->$shortField = $array[$field];
            }
        }
    }

    /**
     * Validate boolean value.
     *
     * @param string|int|float|bool $var Variable to validate.
     *
     * @return bool True if is boolean, false otherwise.
     */
    protected function isBoolean($var)
    {
        if ($var === null) return false;
        $var = strtolower($var);
        return $var === false || $var === true || $var == 0 || $var == 1 || $var === 'on' || $var === 'off';
    }

    /**
     * Validate integer value, optionally with limits.
     *
     * @param string|int|float|bool $var Variable to validate.
     * @param int|null              $min Minimum value.
     * @param int|null              $max Maximum value.
     *
     * @return bool True if is integer, false otherwise.
     */
    protected function isInteger($var, $min = null, $max = null)
    {
        if ($var === null) return false;
        if (!preg_match('/^(\-)?[0-9]+$/', $var))
        {
            return false;
        }
        if ($min !== null)
        {
            if (filter_var($min, FILTER_VALIDATE_INT) === false)
            {
                throw new \InvalidArgumentException("Can't validate integer value. Minimum value supplied is not integer");
            }
            if (intval($var) < $min)
            {
                return false;
            }
        }
        if ($max !== null)
        {
            if (filter_var($max, FILTER_VALIDATE_INT) === false)
            {
                throw new \InvalidArgumentException("Can't validate integer value. Maximum value supplied is not integer");
            }
            if (intval($var) > $max)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate float value, optionally with limits.
     *
     * @param string|int|float|bool $var Variable to validate.
     * @param float|null            $min Minimum value.
     * @param float|null            $max Maximum value.
     *
     * @return bool True if is float, false otherwise.
     */
    protected function isFloat($var, $min = null, $max = null)
    {
        if ($var === null) return false;
        if (!preg_match('/^(\-)?[0-9]*(\.)?[0-9]+$/', $var))
        {
            return false;
        }
        if ($min !== null)
        {
            if (filter_var($min, FILTER_VALIDATE_FLOAT) === false)
            {
                throw new \InvalidArgumentException("Can't validate float value. Minimum value supplied is not float");
            }
            if (intval($var) < $min)
            {
                return false;
            }
        }
        if ($max !== null)
        {
            if (filter_var($max, FILTER_VALIDATE_FLOAT) === false)
            {
                throw new \InvalidArgumentException("Can't validate float value. Maximum value supplied is not float");
            }
            if (intval($var) > $max)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate a string is a valid URL.
     *
     * @param string $var       Value to validate.
     * @param bool   $forceHttp Force https or https as prefix.
     *
     * @return bool True if is URL, false otherwise.
     */
    protected function isURL($var, $forceHttp = false)
    {
        if ($var === null) return false;
        if (!$this->isPattern($var, '/^[a-zA-Z0-9\&\%\#\@\{\}\(\)\-\_\.\:\/]*$/'))
        {
            return false;
        }
        if ($forceHttp)
        {
            if (mb_strlen($var) > 7 && substr(strtolower($var), 0, 7) !== 'http://')
            {
                return false;
            }
            if (mb_strlen($var) > 8 && substr(strtolower($var), 0, 8) !== 'https://')
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate a string is a valid e-mail address.
     *
     * @param string $var Value to validate.
     *
     * @return bool True if is e-mail, false otherwise.
     */
    protected function isEmail($var)
    {
        if ($var === null) return false;
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate string value, optionally with length limits.
     *
     * @param string   $var       Variable to validate.
     * @param int|null $minLength Minimum length.
     * @param int|null $maxLength Maximum length.
     *
     * @return bool True if is string, false otherwise.
     */
    protected function isString($var, $minLength = null, $maxLength = null)
    {
        if ($var === null) return false;
        if ($minLength !== null)
        {
            if (!$this->isInteger($minLength, 0))
            {
                throw new \InvalidArgumentException("Can't validate minimum string length. Minimum is not integer");
            }
            if (mb_strlen($var) < $minLength)
            {
                return false;
            }
        }
        if ($maxLength !== null)
        {
            if (!$this->isInteger($maxLength, 0))
            {
                throw new \InvalidArgumentException("Can't validate maximum string length. Maximum is not integer");
            }
            if (mb_strlen($var) > $maxLength)
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate a string value matches regular expression pattern.
     *
     * @param string $var     Variable to validate.
     * @param string $pattern Pattern to match.
     *
     * @return bool True if is pattern matches, false otherwise.
     */
    protected function isPattern($var, $pattern)
    {
        if ($var === null) return false;
        return preg_match($pattern, $var) === 1;
    }

    /**
     * Validate a string is a valid IP address.
     *
     * @param string $var Variable to validate.
     *
     * @return bool True if is IP address, false otherwise.
     */
    protected function isIpAddress($var)
    {
        if ($var === null) return false;
        $parts = explode('.', $var);
        if (count($parts) !== 4)
        {
            return false;
        }
        foreach ($parts as $part)
        {
            if (!$this->isInteger($part, 0, 255))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate a string is a valid token (0-9 and A-F).
     *
     * @param string $var    Variable to validate.
     * @param int    $length Token length
     *
     * @return bool True if is a valid token, false otherwise.
     */
    protected function isToken($var, $length = 32)
    {
        if ($var === null) return false;
        if (!$this->isInteger($length, 1))
        {
            throw new \InvalidArgumentException("Can't validate token. Length must be an integer larger than zero");
        }
        $pattern = '/^[0-9a-fA-F]{' . $length . '}$/';
        return $this->isPattern($var, $pattern);
    }

    /**
     * Validate a string is a valid date (yyyy-mm-dd)
     *
     * @param string $var Variable to validate.
     *
     * @return bool True if valid date false otherwise.
     */
    protected function isDate($var)
    {
        if ($var === null) return false;
        $d = \DateTime::createFromFormat("Y-m-d", $var);
        return $d !== false;
    }

    /**
     * Validate a string is a valid date-time (yyyy-mm-dd hh:ii:ss)
     *
     * @param string $var Variable to validate.
     *
     * @return bool True if valid date-time false otherwise.
     */
    protected function isDateTime($var)
    {
        if ($var === null) return false;
        $d = \DateTime::createFromFormat("Y-m-d H:i:s", $var);
        return $d !== false;
    }

    /**
     * Validate a string is a valid time (hh:ii:ss)
     *
     * @param string $var Variable to validate.
     *
     * @return bool True if valid time false otherwise.
     */
    protected function isTime($var)
    {
        if ($var === null) return false;
        $d = \DateTime::createFromFormat("H:i:s", $var);
        return $d !== false;
    }

    /**
     * Validate a string exists in a list.
     *
     * @param string $var  Variable to validate.
     * @param array  $list List of values.
     *
     * @return bool True if exists in list, false otherwise.
     */
    protected function isInList($var, $list = [])
    {
        if ($var === null) return false;
        if (!is_array($list))
        {
            throw new \InvalidArgumentException("Can't validate a value is in list. List must be an array");
        }
        return array_search($var, $list) !== false;
    }

    /**
     * Implement to sanitize the entity fields values.
     * By default this function does nothing.
     */
    public function sanitize()
    {
        return;
    }

    /**
     * Implement validation rules.
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public abstract function isValid();
}