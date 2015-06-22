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

namespace Trident\MVC;

use \Trident\System\Configuration;
use \Trident\Exceptions\ViewNotFoundException;

/**
 * Class AbstractView
 *
 * Base class for creating views.
 * Provides access the core Trident framework instances and view data.
 *
 * @package Trident\MVC
 */
abstract class AbstractView
{

    /**
     * AbstractView data array.
     *
     * @var array
     */
    protected $data;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Initialize view.
     *
     * @param Configuration $configuration Configuration instance.
     * @param array         $data          AbstractView data.
     */
    function __construct($configuration, $data)
    {
        $this->configuration = $configuration;
        $this->data = $data;
    }

    /**
     * Get dynamic property.
     *
     * @param string $name Property name.
     *
     * @return mixed|null Property value or null if not found.
     */
    function __get($name)
    {
        if (!isset($this->data[$name]))
        {
            return null;
        }
        return $this->data[$name];
    }

    /**
     * Set dynamic property.
     *
     * @param string $name  Property name.
     * @param mixed  $value Property value.
     */
    function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Check if dynamic property exists.
     *
     * @param string $name Property name.
     *
     * @return bool True if exists, false otherwise.
     */
    function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Render out the view.
     */
    public abstract function render();

    /**
     * Escape html special characters.
     *
     * @param string $var Value to be escaped.
     *
     * @return string Escaped value.
     */
    protected function escape($var)
    {
        return htmlspecialchars($var, ENT_QUOTES | ENT_HTML5);
    }

    /**
     * Print out or return the public path.
     *
     * @param bool $return Set to true to return value instead of print it out.
     *
     * @return string Public application path.
     */
    public function publicPath($return = false)
    {
        try
        {
            $path = $this->configuration->item('paths.public');
        }
        catch (\InvalidArgumentException $e)
        {
            $path = "/";
        }
        if ($return)
        {
            return rtrim($path, '/') . '/';
        }
        echo rtrim($path, '/') . '/';
        return true;
    }

    /**
     * Load shared view instance.
     *
     * @param null  $viewName View name.
     *
     * @throws ViewNotFoundException
     * @return AbstractView View instance.
     */
    protected function getSharedView($viewName)
    {
        try
        {
            $namespace = $this->configuration->item('application.namespace');
        }
        catch (\InvalidArgumentException $e)
        {
            $namespace = "";
        }
        $viewName = $namespace . "\\Views\\Shared\\$viewName";
        if (!class_exists($viewName))
        {
            throw new ViewNotFoundException("Can't load view `$viewName`");
        }
        return new $viewName($this->configuration, $this->data);
    }

    /**
     * Include Javascript file from external source (relative to public path)
     *
     * @param string $file File path
     */
    public function js($file)
    {
        $file = $this->publicPath(true) . $file;
        echo "<script src=\"" . $file . "\"></script>" . PHP_EOL;
    }

    /**
     * Format SQL DateTime field.
     *
     * @param string $sqlDateTime SQL DateTime field data.
     * @param string $source
     * @param string $format
     *
     * @return string
     */
    public function formatSqlDateTime($sqlDateTime, $source = "Y-m-d H:i:s", $format = "d/m/Y H:i:s")
    {
        if ($sqlDateTime === "0000-00-00 00:00:00")
        {
            return "n/a";
        }
        $datetime = \DateTime::createFromFormat($source, $sqlDateTime);
        return $datetime->format($format);
    }
}