<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\License;

class Licenses extends AbstractModel
{
    /**add non deleted find**/
    public function getById($id)
    {
        return $this->getORM()->findById('License', $id);
    }

    public function getAll()
    {
        return $this->getORM()->find('License', "license_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search license values mush be an array");
        }
        return $this->getORM()->find('License',"$term AND license_delete = 0", $values);
    }

    /**
     * @param License $license
     *
     * @return \Trident\Database\Result
     */
    public function add($license)
    {
        return $this->getORM()->save($license);
    }
    /**
     * @param License $license
     *
     * @return \Trident\Database\Result
     */
    public function delete($license)
    {
        $license->delete = 1;
        return $this->getORM()->save($license);

    }
} 