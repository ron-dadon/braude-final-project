<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\User;

class Users extends AbstractModel
{

    public function getById($id)
    {
        return $this->getORM()->findById('User', $id);
    }

    public function getAll()
    {
        return $this->getORM()->find('User');
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search users values mush be an array");
        }
        return $this->getORM()->find('User',$term, $values);
    }

    /**
     * @param User $user
     *
     * @return \Trident\Database\Result
     */
    public function add($user)
    {
        return $this->getORM()->save($user);
    }

} 