<?php

namespace Trident\Request;

class Files
{

    private $_files;

    function __construct()
    {
        $this->_files = [];
        if (!isset($_FILES) || count($_FILES) === 0)
        {
            return;
        }
        foreach ($_FILES as $name => $file)
        {
            if (is_array($file['name']))
            {
                foreach ($file['name'] as $index => $value)
                {
                    $this->_files[$name][$index] = new File(
                        $file['name'][$index],
                        $file['tmp_name'][$index],
                        $file['size'][$index],
                        $file['error'][$index]
                    );
                }
            }
            else
            {
                $this->_files[$name] = new File(
                    $file['name'],
                    $file['tmp_name'],
                    $file['size'],
                    $file['error']
                );
            }
        }
    }

    /**
     * @param      $key
     * @param null $index
     *
     * @return \Trident\Request\File
     */
    public function item($key, $index = null)
    {
        if (!isset($this->_files[$key]))
        {
            throw new \InvalidArgumentException();
        }
        if ($index !== null)
        {
            if (!isset($this->_files[$key][$index]))
            {
                throw new \InvalidArgumentException();
            }
            return $this->_files[$key][$index];
        }
        return $this->_files[$key];
    }
} 