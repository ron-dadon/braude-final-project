<?php

/**
 * Class Global_Array
 */
abstract class Global_Array
{

    /**
     * Array data items
     *
     * @var array
     */
    protected $_data;

    /**
     * Get array item
     *
     * @param string $key   item key
     * @param int    $index item index in case item is an array
     *
     * @return string
     * @throws Trident_Exception
     */
    public function get($key, $index = -1)
    {
        if (isset($this->_data[$key]))
        {
            if ($index >= 0)
            {
                if (isset($this->_data[$key][$index]))
                {
                    return $this->_data[$key][$index];
                }
                else
                {
                    throw new Trident_Exception("Post: index $index of key $key doesn't exists");
                }
            }
            else
            {
                return $this->_data[$key];
            }
        }
        else
        {
            throw new Trident_Exception("Post: key $key doesn't exists");
        }
    }

    /**
     * Get all data
     *
     * @return array
     */
    public function get_all()
    {
        return $this->_data;
    }

    /**
     * Sanitize array keys
     *
     * @param array $var input array
     *
     * @return array
     */
    protected function sanitize($var)
    {
        $output = [];
        foreach ($var as $key => $value)
        {
            $key = filter_var($key, FILTER_SANITIZE_STRING);
            if (is_array($value))
            {
                $output[$key] = $this->sanitize($value);
            }
            else
            {
                $output[$key] = $value;
            }
        }
        return $output;
    }
} 