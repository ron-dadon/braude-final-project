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

use Trident\Exceptions\IOException;

/**
 * Class File
 *
 * Encapsulates uploaded file data.
 *
 * @package Trident\Request
 */
class File
{

    /**
     * Original file name.
     *
     * @var string
     */
    private $name;

    /**
     * Temporary file name.
     *
     * @var string
     */
    private $temporaryName;

    /**
     * File size in bytes.
     *
     * @var int
     */
    private $size;

    /**
     * Mime type of the file.
     *
     * @var string
     */
    private $mime;

    /**
     * File upload error code.
     *
     * @var int
     */
    private $error;

    /**
     * Create a new file.
     *
     * @param string $name          Original file name.
     * @param string $temporaryName Temporary file name.
     * @param int    $size          File size in bytes.
     * @param int    $error         Upload error code.
     */
    function __construct($name, $temporaryName, $size, $error)
    {
        $this->error = $error;
        $this->name = $name;
        $this->size = $size;
        $this->temporaryName = $temporaryName;
        if ($error == UPLOAD_ERR_NO_FILE) return;
        $fileInfo = new \finfo(FILEINFO_MIME);
        $this->mime = $fileInfo->file($temporaryName);
    }

    /**
     * File upload error code.
     *
     * @return int
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * File extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    /**
     * Mime type of the file.
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Original name of the file.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Size of the file in bytes.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * File temporary name.
     *
     * @return string
     */
    public function getTemporaryName()
    {
        return $this->temporaryName;
    }

    /**
     * Save the file to the file system.
     *
     * @param string $path             Path of the directory to save in.
     * @param bool   $createRandomName Create a random name for the file.
     *
     * @return string The save file name (original name or random name if created).
     *
     * @throws IOException
     */
    public function save($path, $createRandomName = false)
    {
        $fileName = $this->name;
        if ($createRandomName)
        {
            $fileName = bin2hex(openssl_random_pseudo_bytes(32));
        }
        $path .= '/' . $fileName;
        $directory = dirname($path);
        if (!file_exists($directory))
        {
            if (!mkdir($directory, 0777, true))
            {
                throw new IOException("Can't save file `$fileName`. Error creating directory");
            }
        }
        if (move_uploaded_file($this->temporaryName, $path) === false)
        {
            throw new IOException("Can't save file `$fileName`");
        }
        return $fileName;
    }

} 