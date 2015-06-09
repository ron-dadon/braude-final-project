<?php

namespace Application\Models;

use Application\Entities\QuoteProduct;
use Trident\Database\Query;
use Trident\MVC\AbstractModel;
use Application\Entities\Quote;

class Quotes extends AbstractModel
{
    public function getById($id)
    {
        /** @var Quote $quote */
        $quote = $this->getORM()->findById('Quote', $id, "quote_delete = 0");
        $quote->client = $this->getORM()->findById('Client', $quote->client, "client_delete = 0");
        $quote->status = $this->getORM()->findById('QuoteStatus', $quote->status, "quote_status_delete = 0");
        $quote->products = [];
        $query = new Query("SELECT * FROM quote_products WHERE quote_product_quote = :id", [":id" => $quote->id]);
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess())
        {
            return $quote;
        }
        foreach ($query->getResultSet() as $productData)
        {
            $quoteProduct = new QuoteProduct();
            $quoteProduct->fromArray($productData, "quote_product_");
            $quoteProduct->product = $this->getORM()->findById('Product', $quoteProduct->product);
            $quote->products[] = $quoteProduct;
        }
        return $quote;
    }

    public function getAll()
    {
        /** @var Quote[] $quotes */
        $quotes = $this->getORM()->find('Quote', "quote_delete = 0");
        foreach ($quotes as $key => $quote)
        {
            $quotes[$key] = $this->getById($quote->id);
        }
        return $quotes;
    }

    /**
     * @return \Application\Entities\QuoteStatus[]
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getAllStatuses()
    {
        return $this->getORM()->find("QuoteStatus", "quote_status_delete = 0");
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
        return $this->getMysql()->executeQuery(new Query("UPDATE " . $quote->getTable() . " SET quote_delete = 1 WHERE quote_id = ?", [$quote->id]));
    }
}