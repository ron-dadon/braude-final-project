<?php


namespace Trident\Request;

class Get
{

    public function item($key, $index = null)
    {
        if (!isset($_GET[$key]))
        {
            throw new \InvalidArgumentException();
        }
        if ($index !== null)
        {
            if (!isset($_GET[$key][$index]))
            {
                throw new \InvalidArgumentException();
            }
            return $_GET[$key][$index];
        }
        return $_GET[$key];
    }

} 