<?php


class Clients_Model extends Trident_Abstract_Model
{

    public function get_all()
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('client', 'SELECT * FROM clients', [], 'client_');
        if ($result->success)
        {
            return $result->result_set;
        }
        else
        {
            return null;
        }
    }
} 