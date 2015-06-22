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

/**
 * Class Log
 *
 * Simple log functionality.
 *
 * @package Trident\System
 */
class Log
{

    /**
     * Logs path.
     *
     * @var string
     */
    private $path;

    /**
     * Initialize logs path.
     *
     * @param string $path Logs path.
     *
     * @throws IOException
     */
    function __construct($path)
    {
        $this->path = $path;
        if (!file_exists($this->path))
        {
            if (mkdir($this->path, 0777, true) === false)
            {
                throw new IOException("Can't create logs directory in the path `$path`");
            }
        }
    }

    /**
     * Add a new log entry.
     * If the log file exists - append the log entry, otherwise create a new log file.
     * Log file is created for each date.
     *
     * @param string $entry Log entry.
     * @param string $log   Log file.
     *
     * @throws IOException
     */
    public function newEntry($entry, $log = '')
    {
        $date = date('d-m-Y');
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $time = date('H:i:s');
        $line = "\"$date\",\"$time\",\"$entry\"";
        $path = $this->path . ($log !== '' ? $log : '') . '/' . $year . '/' . $month;
        if (!file_exists($path))
        {
            if (mkdir($path, 0777, true) === false)
            {
                throw new IOException("Can't create logs directory in the path `$path`");
            }
        }
        $path .= '/' . $day . '.log';
        if (file_exists($path))
        {
            if (!is_writable($path))
            {
                throw new IOException();
            }
            if (file_put_contents($path, PHP_EOL . $line, LOCK_EX | FILE_APPEND) === false)
            {
                throw new IOException();
            }
        }
        else
        {
            $line = "\"Date\",\"Time\",\"Entry\"" . PHP_EOL . $line;
            if (file_put_contents($path, $line, LOCK_EX | FILE_APPEND) === false)
            {
                throw new IOException();
            }
        }
    }

} 