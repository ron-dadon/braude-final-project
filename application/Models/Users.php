<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\User;

class Users extends AbstractModel
{
/**add non deleted find**/
    public function getById($id)
    {
        return $this->getORM()->findById('User', $id);
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
        return $this->getORM()->save($user);
    }
    /**
     * @param User $user
     *
     * @return \Trident\Database\Result
     */
    public function delete($user)
    {
        $user->delete = 1;
        return $this->getORM()->save($user);

    }


} 