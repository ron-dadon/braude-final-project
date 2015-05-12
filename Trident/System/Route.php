<?php


namespace Trident\System;

class Route
{

    /**
     * Route regular expression pattern.
     *
     * @var string
     */
    private $_pattern;

    /**
     * Route controller.
     *
     * @var string
     */
    private $_controller;

    /**
     * Route method.
     *
     * @var string
     */
    private $_method;

    /**
     * Route parameters.
     *
     * @var array
     */
    private $_parameters;

    /**
     * Initialize route.
     *
     * @param string $controller Route controller.
     * @param string $method     Route method.
     * @param string $pattern    Route simple pattern.
     */
    function __construct($controller, $method, $pattern)
    {
        $this->_controller = $controller;
        $this->_method = $method;
        $this->_parse_pattern($pattern);
    }

    /**
     * Parses the basic pattern to a regular expression pattern and extract the parameters from it.
     *
     * @param string $pattern Basic pattern.
     */
    private function _parse_pattern($pattern)
    {
        $parameters = [];
        $this->_parameters = [];
        preg_match_all('/(\{[\d\w]+\})/', $pattern, $parameters);
        unset($parameters[1]);
        $this->_pattern = '/^' . str_replace('/', chr(92) . '/', $pattern) . '$/';
        if (count($parameters[0]))
        {
            foreach ($parameters[0] as $key => $parameter)
            {
                $extracted_parameter = str_replace('{', '', $parameter);
                $extracted_parameter = str_replace('}', '', $extracted_parameter);
                $this->_parameters[] = $extracted_parameter;
                $this->_pattern = str_replace($parameter, '(?P<' . $extracted_parameter . '>[\d\w\-\_]+)', $this->_pattern);
            }
        }
        preg_match_all('/(\([\d\w]+\))/', $pattern, $parameters);
        unset($parameters[1]);
        if (count($parameters[0]))
        {
            foreach ($parameters[0] as $key => $parameter)
            {
                $extracted_parameter = str_replace('(', '', $parameter);
                $extracted_parameter = str_replace(')', '', $extracted_parameter);
                $this->_parameters[] = $extracted_parameter;
                $this->_pattern = str_replace($parameter, '(?P<' . $extracted_parameter . '>[\d]+)', $this->_pattern);
            }
        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->_parameters;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->_pattern;
    }

    /**
     * @param array $parameters
     */
    public function setParameters($parameters)
    {
        $this->_parameters = $parameters;
    }

}