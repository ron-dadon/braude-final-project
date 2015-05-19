<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Quote;

class Quotes extends AbstractModel
{
    public function getById($id)
    {
        return $this->getORM()->findById('Quote', $id, "quote_delete = 0");
    }

    public function getAll()
    {
        return $this->getORM()->find('Quote', "quote_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search quotes values mush be an array");
        }
        return $this->getORM()->find('Quote',"$term AND quote_delete = 0", $values);
    }

    /**
     * @param Quote $quote
     *
     * @return \Trident\Database\Result
     */
    public function add($quote)
    {
        return $this->getORM()->save($quote);
    }
    /**
     * @param Quote $quote
     *
     * @return \Trident\Database\Result
     */
    public function delete($quote)
    {
        $quote->delete = 1;
        return $this->getORM()->save($quote);

    }
}