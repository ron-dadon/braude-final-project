<?php


class Contacts_Model extends Trident_Abstract_Model
{

    /**
     * @param Client_Entity $client
     *
     * @return Contact_Entity[]|null
     */
    public function get_all_for_client($client)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('contact', 'SELECT * FROM contacts WHERE contact_client = :client AND contact_delete = 0', ['client' => $client->id], 'contact_');
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