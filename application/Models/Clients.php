<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Client;

class Clients extends AbstractModel
{
    /**add non deleted find**/
    public function getById($id)
    {
        return $this->getORM()->findById('Client', $id);
    }

    public function getAll()
    {
        return $this->getORM()->find('Client', "client_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search clients values mush be an array");
        }
        return $this->getORM()->find('Client',"$term AND client_delete = 0", $values);
    }

    /**
     * @param Client $client
     *
     * @return \Trident\Database\Result
     */
    public function add($client)
    {
        return $this->getORM()->save($client);
    }
    /**
     * @param Client $client
     *
     * @return \Trident\Database\Result
     */
    public function delete($client)
    {
        $client->delete = 1;
        return $this->getORM()->save($client);

    }
} 