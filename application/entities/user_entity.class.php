<?php

class User_Entity extends Trident_Abstract_Entity
{

    public $id;
    public $name;
    public $email;
    public $salt;
    public $password;
    public $admin;
    public $last_activity;
    public $last_ip;
    public $last_browser;
    public $last_platform;
} 