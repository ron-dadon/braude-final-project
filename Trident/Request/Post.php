<?php

namespace Trident\Request;

class Post
{

    public function item($key, $index = null)
    {
        if (!isset($_POST[$key]))
        {
            throw new \InvalidArgumentException();
        }
        if ($index !== null)
        {
            if (!isset($_POST[$key][$index]))
            {
                throw new \InvalidArgumentException();
            }
            return $_POST[$key][$index];
        }
        return $_POST[$key];
    }

} 