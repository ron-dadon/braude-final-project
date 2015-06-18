<?php

namespace Application\Models;

use Trident\Database\Query;
use Trident\MVC\AbstractModel;
use Application\Entities\Client;

class Clients extends AbstractModel
{

    /**
     * @param $id
     *
     * @return null|\Application\Entities\Client
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getById($id)
    {
        return $this->getORM()->findById('Client', $id, "client_delete = 0");
    }

    public function count()
    {
        $query = new Query('SELECT COUNT(client_id) AS counter FROM clients WHERE client_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
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
     * @param $client
     * @return \Trident\Database\Result
     */
    public function update($client)
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