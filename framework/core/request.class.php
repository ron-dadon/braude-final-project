<?php

/**
 * Class Request
 */
class Request
{

    /**
     * Post object
     *
     * @var Post
     */
    public $post;

    /**
     * Get object
     *
     * @var Get
     */
    public $get;

    /**
     * Server object
     *
     * @var Server
     */
    public $server;

    /**
     * Files object
     *
     * @var Files
     */
    public $files;

    /**
     * Cookie object
     *
     * @var Cookie
     */
    public $cookie;

    /**
     * Session object
     *
     * @var Session
     */
    public $session;

    /**
     * Request type (GET, POST, PUT...)
     *
     * @var string
     */
    public $type;

    /**
     * Request constructor
     *
     * Build request main objects.
     * Unset global arrays if required.
     *
     * @param bool $unset_globals unset global array after objects initialization
     */
    function __construct($unset_globals = false)
    {
        $this->files = new Files();
        $this->post = new Post();
        $this->get = new Get();
        $this->cookie = new Cookie();
        $this->server = new Server();
        $this->session = new Session();
        $this->type = $this->server->get('REQUEST_METHOD');
        if ($unset_globals)
        {
            $this->_unset_globals();
        }
    }

    /**
     * Unset global arrays except session and cookie arrays
     */
    private function _unset_globals()
    {
        unset($_GET);
        unset($_FILES);
        unset($_POST);
        unset($_SERVER);
    }
} 