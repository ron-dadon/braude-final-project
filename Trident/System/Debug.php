<?php

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