<?php

class User_Entity extends Trident_Abstract_Entity
{

    public $id = null;
    public $email = '';
    public $first_name = '';
    public $last_name = '';
    public $admin = 0;
    public $last_activity = '0000-00-00 00:00:00';
    public $delete = 0;

    function __construct()
    {
        $this->table_name = 'users';
        $this->field_prefix = 'user_';
        $this->primary_key_field = 'id';
    }

}