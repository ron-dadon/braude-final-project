<?php


class Clients_Model extends Trident_Abstract_Model
{

    /**
     * @return Client_Entity[]|null
     */
    public function get_all()
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('client', 'SELECT * FROM clients WHERE client_delete = 0', [], 'client_');
        if ($result->success)
        {
            return $result->result_set;
        }
        else
        {
            return null;
        }
    }

    /**
     * @param $id
     *
     * @return Client_Entity|null
     */
    public function get_client_by_id($id)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('client', 'SELECT * FROM clients WHERE client_id = :id AND client_delete = 0', ['id' => $id], 'client_');
        if ($result->success && $result->row_count === 1)
        {
            return $result->result_set[0];
        }
        else
        {
            return null;
        }
    }

    /**
     * @param Client_Entity $client
     */
    public function delete_client($client)
    {
        /** @var Trident_Query_MySql $result */
        $client->delete = true;
        $result = $this->database->update_entity($client, 'clients', 'id', 'client_');
        return $result->success;
    }

    /**
     * @param Client_Entity $client
     */
    public function update_client($client)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->update_entity($client, 'clients', 'id', 'client_');
        return $result->success;
    }

} 