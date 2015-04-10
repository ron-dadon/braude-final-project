<?php


class Users_Model extends Trident_Abstract_Model
{

    public function get_user_by_login_information($email, $password)
    {
        $result = $this->database->select_entity('user', 'SELECT * FROM users WHERE user_email = :email', [':email' => $email], 'user_');
        
    }
}