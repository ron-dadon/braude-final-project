<?php


class Users_Model extends Trident_Abstract_Model
{

    public function get_user_by_id($id)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('user', 'SELECT * FROM users WHERE user_id = :id', [':id' => $id], 'user_');
        if ($result->success && $result->row_count === 1)
        {
            return $result->result_set[0];
        }
        else
        {
            return null;
        }
    }

    public function get_user_by_login_information($email, $password)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('user', 'SELECT * FROM users WHERE user_email = :email', [':email' => $email], 'user_');
        if ($result->success && $result->row_count === 1)
        {
            /** @var User_Entity $user */
            $user = $result->result_set[0];
            /** @var Security_Library $security */
            $security = $this->load_library('security');
            $password = $security->hash($password, $user->salt);
            if ($password === $user->password)
            {
                return $user;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }

    public function delete_user($user)
    {
        return $this->database->delete_entity($user, 'users' ,'id', 'user_');
    }

    public function add_user($user)
    {
        return $this->database->insert_entity($user, 'users', 'user_');
    }

    public function update_user($user)
    {
        return $this->database->update_entity($user, 'users', 'id', 'user_');
    }
}