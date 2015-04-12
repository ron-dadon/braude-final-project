<?php


class Contacts_Model extends Trident_Abstract_Model
{

    public function get_contact_by_id($id)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->select_entity('contact', 'SELECT * FROM contacts WHERE contact_id = :id AND contact_delete = 0', ['id' => $id], 'contact_');
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
     * @param Contact_Entity $contact
     */
    public function delete_contact($contact)
    {
        /** @var Trident_Query_MySql $result */
        $contact->delete = true;
        $result = $this->database->update_entity($contact, 'contacts', 'id', 'contact_');
        return $result->success;
    }

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

    /**
     * @param Contact_Entity $contact
     *
     * @return Trident_Query_MySql
     */
    public function add_contact($contact)
    {
        /** @var Trident_Query_MySql $result */
        $result = $this->database->insert_entity($contact, 'contacts', 'contact_');
        return $result;
    }

} 