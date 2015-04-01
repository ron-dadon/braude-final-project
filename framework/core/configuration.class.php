<?php

/**
 * Class Configuration
 */
class Configuration
{

    /**
     * Configuration sections and key-value pairs
     *
     * @var array
     */
    protected $_data;

    /**
     * Get configuration item
     *
     * @param string $section item section
     * @param string $key     item key
     *
     * @return string
     * @throws Trident_Exception
     */
    public function get($section, $key)
    {
        if (isset($this->_data[$section]))
        {
            if (isset($this->_data[$section][$key]))
            {
                return ($this->_data[$section][$key]);
            }
            else
            {
                throw new Trident_Exception("Configuration: key $key doesn't exists in section $section");
            }
        }
        else
        {
            throw new Trident_Exception("Configuration: section $section doesn't exists");
        }
    }

    /**
     * Load configuration from file
     *
     * @param string $file ini file path
     *
     * @throws Trident_Exception
     */
    public function load($file)
    {
        if (!file_exists($file) || !is_readable($file))
        {
            throw new Trident_Exception("Configuration: file $file doesn't exists or is not readable");
        }
        if (($data = parse_ini_file($file, true)) === false)
        {
            throw new Trident_Exception("Configuration: file $file is corrupted or not a valid ini file");
        }
        $this->_data = $data;
    }

    /**
     * Save configuration to file
     *
     * @param string $file ini file path
     *
     * @throws Trident_Exception
     */
    public function save($file)
    {
        if (file_exists($file) && !is_writable($file))
        {
            throw new Trident_Exception("Configuration: file $file is not writable");
        }
        $data = '';
        foreach ($this->_data as $section => $sectionData)
        {
            $data .= '[' . $section . ']' . PHP_EOL;
            foreach ($sectionData as $key => $value)
            {
                $data .= $key . ' = ' . $value . PHP_EOL;
            }
            $data .= PHP_EOL;
        }
        if (file_put_contents($file, $data, LOCK_EX) === false)
        {
            throw new Trident_Exception("Configuration: error writing to file $file");
        }
    }

    /**
     * Set configuration item
     *
     * @param string          $section item section
     * @param string          $key     item key
     * @param string|int|bool $value   item value
     */
    public function set($section, $key, $value)
    {
        $this->_data[$section][$key] = $value;
    }

    /**
     * Does a section exists in the configuration
     *
     * @param string $section section name
     *
     * @return bool
     */
    public function is_section_exists($section)
    {
        return isset($this->_data[$section]) && is_array($this->_data[$section]);
    }
}