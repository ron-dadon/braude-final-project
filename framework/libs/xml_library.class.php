<?php

/**
 * Class XML
 *
 * Basic XML file writer
 */
class XML_Library extends Library
{
    /**
     * 2D associative array of the data
     * Each array element is an associative array
     *
     * @var array[]
     */
    private $_data;

    /**
     * Name of a single object in the xml data
     * For example: Student
     *
     * @var string
     */
    private $_objectName;

    /**
     * Name of the set of objects in the xml data, usually the plural of the object name
     * For example: Students
     *
     * @var string
     */
    private $_objectNames;

    /**
     * Class constructor
     *
     * @param array  $data        xml data
     * @param string $objectName  single object name
     * @param string $objectNames set of objects name
     */
    function __construct($data = [], $objectName = '', $objectNames = '')
    {
        $this->_data = $data;
        $this->_objectName = $objectName;
        $this->_objectNames = $objectNames;
    }

    /**
     * Set a set of objects name
     *
     * @param string $name name of a set of objects
     */
    public function setObjectsName($name)
    {
        $this->_objectNames = $name;
    }

    /**
     * Set single object name
     *
     * @param string $name name of an object
     */
    public function setObjectName($name)
    {
        $this->_objectName = $name;
    }

    /**
     * Set xml data
     *
     * @param array $data xml data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Output the xml data as a string
     *
     * @return string xml file data
     */
    public function writeToString()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content .= '<' . $this->_objectNames . '>' . PHP_EOL;
        foreach ($this->_data as $row)
        {
            $content .= '<' . $this->_objectName . '>' . PHP_EOL;
            foreach ($row as $key => $data)
            {
                $content .= '<' . $key . '>' . $data . '</' . $key . '>' . PHP_EOL;
            }
            $content .= '</' . $this->_objectName . '>' . PHP_EOL;
        }
        $content .= '</' . $this->_objectNames . '>';
        return $content;
    }

    /**
     * Output the xml data (same as using echo $this->writeToString();)
     */
    public function writeToStdOut()
    {
        echo $this->writeToString();
    }

    /**
     * Output the xml data to a xml file
     *
     * @param string $file file name
     */
    public function writeToFile($file)
    {
        file_put_contents($file, $this->writeToString());
    }
}