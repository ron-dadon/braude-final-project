<?php

/**
 * Class CSV_Library
 */
class CSV_Library extends Library
{

    /**
     * 2D associative array of the data
     *
     * @var array
     */
    private $_data;

    /**
     * Class constructor
     *
     * Build object and set the data
     *
     * @param array $data csv data
     */
    function __construct($data = [])
    {
        $this->_data = $data;
    }

    /**
     * Set csv data
     *
     * @param array $data csv data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Output the csv data as a string
     *
     * @return string csv file data
     */
    public function writeToString()
    {
        $content = '';
        for ($i = 0; $i < count($this->_data); $i++)
        {
            $content .= '"' . implode('", "', $this->_data[$i]) . '"' . ($i < count($this->_data) - 1 ? PHP_EOL : '');
        }
        return $content;
    }

    /**
     * Output the csv data (same as using echo $this->writeToString();)
     */
    public function writeToStdOut()
    {
        echo $this->writeToString();
    }

    /**
     * Output the csv data to a csv file
     *
     * @param string $file file name
     */
    public function writeToFile($file)
    {
        file_put_contents($file, $this->writeToString());
    }
} 