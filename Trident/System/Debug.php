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
 * Class Debug
 *
 * A simple debug information functionality.
 * Display information such as process time, global arrays values, server etc.
 *
 * @package Trident\System
 */
class Debug
{

    /**
     * Process start time.
     *
     * @var float
     */
    private $_startTime;

    /**
     * Process end time.
     *
     * @var float
     */
    private $_endTime;

    /**
     * Initialize debug.
     */
    function __construct()
    {
        $this->_startTime = microtime(true);
    }

    /**
     * Output debug information.
     */
    public function showInformation()
    {
        $this->_endTime = microtime(true);
        $processTime = $this->_endTime - $this->_startTime;
        $memory = ceil(memory_get_peak_usage() / 1024) . " / " . ceil(memory_get_peak_usage(true) / 1024);
        $server = print_r($_SERVER, true);
        $session = print_r($_SESSION, true);
        $post = print_r($_POST, true);
        $get = print_r($_GET, true);
        $files = print_r($_FILES, true);
        $cookie = print_r($_COOKIE, true);
        $output = <<<EOT
<div class="container-fluid">
    <pre id="trident-framework-debug" dir="ltr">
    Processing time: $processTime [sec]
    Memory: $memory [kb]
    Server: $server
    Session: $session
    Cookie: $cookie
    Get: $get
    Post: $post
    Files: $files
    </pre>
</div>
EOT;
        echo $output;
    }

} 