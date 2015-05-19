<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\User;

class Users extends AbstractModel
{

    /**
     * @param $id
     *
     * @return null|\Application\Entities\User
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getById($id)
    {
        return $this->getORM()->findById('User', $id, "user_delete = 0");
    }

    public function getAll()
    {
        return $this->getORM()->find('User', "user_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search users values mush be an array");
        }
        return $this->getORM()->find('User',"$term AND user_delete = 0", $values);
    }

    /**
     * @param User $user
     *
     * @return \Trident\Database\Result
     */
    public function add($user)
    {
        if (!$user instanceof User)
        {
            throw new \InvalidArgumentException("Add user argument must be a valid User entity");
        }
        return $this->getORM()->save($user);
    }
    /**
     * @param User $user
     *
     * @return \Trident\Database\Result
     */
    public function delete($user)
    {
        if (!$user instanceof User)
        {
            throw new \InvalidArgumentException("Add user argument must be a valid User entity");
        }
        $user->delete = 1;
        return $this->getORM()->save($user);
    }

} 