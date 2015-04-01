<?php

/**
 * Class File
 */
class File
{

    /**
     * File error code
     *
     * @var int
     */
    public $error;

    /**
     * File size
     *
     * @var int
     */
    public $size;

    /**
     * File temporary file name
     *
     * @var string
     */
    public $temporary_name;

    /**
     * File name
     *
     * @var string
     */
    public $name;

    /**
     * File mime type
     *
     * @var string
     */
    public $mime;

    // Error constants
    const ERROR_OK                     = UPLOAD_ERR_OK;
    const ERROR_EXCEED_MAX_FILE_SIZE   = UPLOAD_ERR_INI_SIZE;
    const ERROR_EXCEED_MAX_UPLOAD_SIZE = UPLOAD_ERR_FORM_SIZE;
    const ERROR_PARTIAL                = UPLOAD_ERR_PARTIAL;
    const ERROR_MISSING                = UPLOAD_ERR_NO_FILE;
    const ERROR_MISSING_TEMP_FOLDER    = UPLOAD_ERR_NO_TMP_DIR;
    const ERROR_WRITE                  = UPLOAD_ERR_CANT_WRITE;
    const ERROR_UNKNOWN                = UPLOAD_ERR_EXTENSION;

    /**
     * File constructor
     *
     * Build file object
     *
     * @param int    $error          error code
     * @param string $name           file name
     * @param int    $size           file size in bytes
     * @param string $temporary_name file temporary name
     */
    function __construct($error, $name, $size, $temporary_name)
    {
        $this->error = $error;
        $this->name = $name;
        $this->size = $size;
        $this->temporary_name = $temporary_name;
        $this->mime = '';
        if (file_exists($this->temporary_name) && is_readable($this->temporary_name))
        {
            $info = new finfo(FILEINFO_MIME_TYPE);
            $this->mime = $info->file($this->temporary_name);
        }
    }

    /**
     * Delete temporary file
     */
    public function delete()
    {
        unlink($this->temporary_name);
    }

    /**
     * Save file
     *
     * @param string $to path to save the file
     *
     * @return bool
     */
    public function save($to)
    {
        return move_uploaded_file($this->temporary_name, $to);
    }
} 