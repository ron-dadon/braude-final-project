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

use \Trident\Exceptions\IOException;
use \Trident\Exceptions\JsonParseException;
use \InvalidArgumentException;

/**
 * Class Configuration
 *
 * Wrapper for configuration information.
 *
 * @package Trident\System
 */
class Configuration
{

    /**
     * Configuration items array.
     *
     * @var array
     */
    protected $data;

    /**
     * Initialize configuration.
     * Load configuration from a file is one is specified.
     *
     * @param string|null $file Path of the configuration file to load.
     *
     * @throws JsonParseException
     */
    function __construct($file = null)
    {
        if ($file !== null)
        {
            $this->load($file);
        }
        else
        {
            $this->data = [];
        }
    }

    /**
     * Get configuration item.
     *
     * @param string $key Configuration item key.
     *
     * @return string|int|float|bool|array Configuration item.
     */
    public function item($key)
    {
        if (!isset($this->data[$key]))
        {
            throw new InvalidArgumentException("Configuration item `$key` not found");
        }
        return $this->data[$key];
    }

    /**
     * Set configuration item.
     *
     * @param string                      $key   Configuration item key.
     * @param string|int|float|bool|array $value Configuration item.
     */
    public function set($key, $value)
    {
        if (!isset($this->data[$key]))
        {
            throw new InvalidArgumentException();
        }
        $this->data[$key] = $value;
    }

    /**
     * Load configuration from file.
     *
     * @param string $file Configuration file path.
     *
     * @throws JsonParseException
     */
    public function load($file)
    {
        if (!file_exists($file))
        {
            throw new InvalidArgumentException();
        }
        $data = json_decode(file_get_contents($file), true);
        if (!$data || !is_array($data))
        {
            throw new JsonParseException();
        }
        $this->data = $data;
    }

    /**
     * Save configuration to file.
     *
     * @param string $file Configuration file path.
     *
     * @throws IOException
     * @throws JsonParseException
     */
    public function save($file)
    {
        if (file_exists($file) && !is_writable($file))
        {
            throw new IOException();
        }
        $json = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false)
        {
            throw new JsonParseException();
        }
        if (file_put_contents($file, $json, LOCK_EX) === false)
        {
            throw new IOException();
        }
    }
} 