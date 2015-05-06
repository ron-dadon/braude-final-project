<?php

class Users_Model extends Trident_Abstract_Model
{

    /**
     * Get all the users.
     *
     * @return User_Entity[]
     */
    public function get_all()
    {
        $query = 'SELECT * FROM users';
        $result = $this->database->select_entity('user', $query, []);
        return $result->success ? $result->result_set : [];
    }

    /**
     * Get a user by it's id number.
     *
     * @param int $id User id.
     *
     * @return User_Entity|null
     */
    public function get_by_id($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT) === false || $id < 1)
        {
            return null;
        }
        $query = 'SELECT * FROM users WHERE user_id = :id';
        $result = $this->database->select_entity('user', $query, [':id' => $id]);
        return $result->success && $result->row_count === 0 ? $result->result_set[0] : null;
    }

    /**
     * Search users.
     *
     * @param array $terms Array of field => value search terms.
     *
     * @return User_Entity[]
     */
    public function search($terms = [])
    {
        $user = new User_Entity();
        $fields = $user->get_field_names();
        $query = 'SELECT * FROM users WHERE 1';
        $values = [];
        foreach ($terms as $field => $value)
        {
            if (array_search($field, $fields) !== false)
            {
                $query .= " AND user_$field LIKE :$field";
                $values[":$field"] = "%$value%";
            }
        }
        if (count($values) > 0)
        {
            $result = $this->database->select_entity('user', $query, $values);
            return $result->success ? $result->result_set : [];
        }
        return [];
    }

    /**
     * Add new user.
     *
     * @param User_Entity $user User to add.
     *
     * @return bool True on success, false otherwise.
     */
    public function add($user)
    {
        if (get_class($user) !== 'User_Entity')
        {
            return false;
        }
        $result = $this->database->insert_entity($user);
        return $result->success;
    }

    /**
     * Update an existing user.
     *
     * @param User_Entity $user User to update.
     *
     * @return True on success, false otherwise.
     */
    public function update($user)
    {
        if (get_class($user) !== 'User_Entity')
        {
            return false;
        }
        $result = $this->database->update_entity($user);
        return $result->success;
    }

    /**
     * Delete a user.
     *
     * @param User_Entity $user User to delete.
     *
     * @return True on success, false otherwise.
     */
    public function delete($user)
    {
        if (get_class($user) !== 'User_Entity')
        {
            return false;
        }
        $user->delete = 1;
        return $this->update($user);
    }

} 