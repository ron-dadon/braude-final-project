<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\User;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\ModelNotFoundException;
use Trident\Exceptions\MySqlException;

/**
 * Class Users
 *
 * This class provides the data-access layer to the users in the database.
 *
 * @package Application\Models
 */
class Users extends AbstractModel
{

    /**
     * Get user by it's ID.
     *
     * @param string|int $id User ID.
     *
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        return $this->getORM()->findById('User', $id, "user_delete = 0");
    }

    /**
     * Get all the users in the system.
     *
     * @return User[]|null
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        return $this->getORM()->find('User', "user_delete = 0");
    }

    /**
     * Get users that match the search.
     *
     * @param string $term Search term (WHERE condition).
     * @param array $values Term parameters values.
     *
     * @return User[]|null
     * @throws EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search users values mush be an array");
        }
        return $this->getORM()->find('User',"$term AND user_delete = 0", $values);
    }

    /**
     * Add a user to the system.
     *
     * @param User $user
     *
     * @return Result
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
     * Delete a user from the system.
     *
     * @param User $user
     *
     * @return Result
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