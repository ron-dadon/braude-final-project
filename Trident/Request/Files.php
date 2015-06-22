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

namespace Trident\Request;

/**
 * Class Files
 *
 * A simple wrapper for handling uploaded files.
 *
 * @package Trident\Request
 */
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