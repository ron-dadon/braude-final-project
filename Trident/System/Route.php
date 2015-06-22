<?php
/**
 * Trident Framework - PHP MVC Framework
 *
 * The MIT License (MIT)
 * Copyright (c) 2015 Ron Dadon
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Trident\System;

/**
 * Class Route
 *
 * Single route information object.
 *
 * @package Trident\System
 */
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