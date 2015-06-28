<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Trident\Database\Query;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\MySqlException;
use Trident\MVC\AbstractModel;
use Application\Entities\Client;

/**
 * Class Clients
 *
 * This class provides the data-access layer to the clients in the database.
 *
 * @package Application\Models
 */
class Clients extends AbstractModel
{

    /**
     * Get client by it's ID.
     *
     * @param string|int $id Client ID.
     *
     * @return Client|null
     *
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        return $this->getORM()->findById('Client', $id, "client_delete = 0");
    }

    /**
     * Get the number of clients in the system.
     *
     * @return int
     *
     * @throws MySqlException
     */
    public function count()
    {
        $query = new Query('SELECT COUNT(client_id) AS counter FROM clients WHERE client_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    /**
     * Get all the clients in the system.
     *
     * @return Client[]|null
     *
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        return $this->getORM()->find('Client', "client_delete = 0");
    }

    /**
     * Get clients that match the search.
     *
     * @param string $term Search term (WHERE condition).
     * @param array $values Term parameters values.
     *
     * @return Client[]|null
     * @throws EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search clients values mush be an array");
        }
        return $this->getORM()->find('Client',"$term AND client_delete = 0", $values);
    }

    /**
     * Add a new client to the system.
     *
     * @param Client $client
     *
     * @return Result
     */
    public function add($client)
    {
        return $this->getORM()->save($client);
    }

    /**
     * Update client in the system.
     *
     * @param Client $client
     *
     * @return Result
     */
    public function update($client)
    {
        return $this->getORM()->save($client);
    }

    /**
     * Delete client from the system.
     *
     * @param Client $client
     *
     * @return Result
     */
    public function delete($client)
    {
        $client->delete = 1;
        return $this->getORM()->save($client);

    }

    /**
     * Get all non active client.
     * A non active client is a client without any quotes.
     *
     * @return Client[]|null
     * @throws MySqlException
     */
    public function getNonActiveClients()
    {
        $query = new Query("SELECT DISTINCT quote_client FROM quotes WHERE quote_delete = 0");
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return null;
        if (!$query->getRowCount()) return [];
        $ids = [];
        foreach ($query->getResultSet() as $row) {
            $ids[] = $row['quote_client'];
        }
        $ids = implode(',', $ids);
        return $this->search("client_id NOT IN ({$ids})",[]);
    }
} 