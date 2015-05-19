<?php


namespace Application\Models;


use Trident\MVC\AbstractModel;
use Application\Entities\Contact;

class Contacts extends AbstractModel{

    public function getById($id)
    {
        return $this->getORM()->findById('Contact', $id, "contact_delete = 0");
    }

    public function getAll()
    {
        return $this->getORM()->find('Contact', "contact_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search contact values mush be an array");
        }
        return $this->getORM()->find('Contact',"$term AND contact_delete = 0", $values);
    }

    /**
     * @param Contact $contact
     *
     * @return \Trident\Database\Result
     */
    public function add($contact)
    {
        return $this->getORM()->save($contact);
    }
    /**
     * @param Contact $contact
     *
     * @return \Trident\Database\Result
     */
    public function delete($contact)
    {
        $contact->delete = 1;
        return $this->getORM()->save($contact);

    }
} 