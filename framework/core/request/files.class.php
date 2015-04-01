<?php

/**
 * Class Files
 */
class Files
{

    /**
     * File objects
     *
     * @var File[]
     */
    private $_files;

    /**
     * Files constructor
     *
     * Transpose $_FILES global array for easier access and build file objects array
     */
    function __construct()
    {
        $files = $this->_transpose_files_array();
        $this->_build_files($files);
    }

    /**
     * Get file object
     *
     * @param string $key   file key
     * @param int    $index file index if object is array
     *
     * @return File
     * @throws Trident_Exception
     */
    public function get($key, $index = -1)
    {
        if (isset($this->_files[$key]))
        {
            if ($index >= 0)
            {
                if (isset($this->_files[$key][$index]))
                {
                    return $this->_files[$key][$index];
                }
                else
                {
                    throw new Trident_Exception("Files: index $index of key $key doesn't exists");
                }
            }
            else
            {
                return $this->_files[$key];
            }
        }
        else
        {
            throw new Trident_Exception("Files: key $key doesn't exists");
        }
    }

    /**
     * Get all
     *
     * @return File[]
     */
    public function get_all()
    {
        return $this->_files;
    }

    /**
     * Build files objects
     *
     * @param array $files
     */
    private function _build_files($files)
    {
        $this->_files = [];
        foreach ($files as $name => $data)
        {
            if (isset($data[0]))
            {
                foreach ($data as $file)
                {
                    $this->_files[$name][] = new File($file['error'], $file['name'], $file['size'], $file['tmp_name']);
                }
            }
            else
            {
                $this->_files[$name] = new File($data['error'], $data['name'], $data['size'], $data['tmp_name']);
            }
        }
    }

    /**
     * Transpose file array for easier handling
     *
     * @return array
     */
    private function _transpose_files_array()
    {
        $output = [];
        foreach ($_FILES as $key => $properties)
        {
            if (is_array($properties['name']))
            {
                foreach ($properties as $property => $values)
                {
                    foreach ($values as $number => $value)
                    {
                        $output[$key][$number][$property] = $value;
                    }
                }
            }
            else
            {
                $output[$key] = $properties;
            }
        }
        return $output;
    }
}