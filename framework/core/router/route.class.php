<?php

/**
 * Class Route
 */
class Route
{

    /**
     * Route pattern
     *
     * @var string
     */
    public $pattern;

    /**
     * Route controller name
     *
     * @var string
     */
    public $controller;

    /**
     * Route method name
     *
     * @var string
     */
    public $method;

    /**
     * Route parameters names
     *
     * @var array
     */
    public $parameters;

    /**
     * Router constructor
     *
     * Build route object
     *
     * @param string $controller controller name
     * @param string $method     method name
     * @param string $pattern    route pattern
     */
    function __construct($controller, $method, $pattern)
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->_parse_pattern($pattern);
    }

    /**
     * Parse pattern to valid regular expression
     *
     * @param string $pattern pattern to parse
     */
    private function _parse_pattern($pattern)
    {
        $this->parameters = [];
        preg_match_all('/(\{[\d\w]+\})/', $pattern, $this->parameters);
        unset($this->parameters[1]);
        $this->pattern = '/^' . str_replace('/', chr(92) . '/', $pattern) . '$/';
        if (count($this->parameters[0]))
        {
            foreach ($this->parameters[0] as $key => $parameter)
            {
                $extracted_parameter = str_replace('{', '', $parameter);
                $extracted_parameter = str_replace('}', '', $extracted_parameter);
                $this->parameters[$key] = $extracted_parameter;
                $this->pattern = str_replace($parameter, '(?P<' . $extracted_parameter . '>[\d\w]+)', $this->pattern);
            }
        }
        else
        {
            $this->parameters = [];
        }
    }
}