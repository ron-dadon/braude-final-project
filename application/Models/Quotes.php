<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Application\Entities\QuoteProduct;
use Trident\Database\Query;
use Trident\MVC\AbstractModel;
use Application\Entities\Quote;
use Application\Entities\QuoteStatus;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\ModelNotFoundException;
use Trident\Exceptions\MySqlException;

/**
 * Class Quotes
 *
 * This class provides the data-access layer to the quotes in the database.
 *
 * @package Application\Models
 */
class Quotes extends AbstractModel
{

    /**
     * Get quote by it's ID.
     *
     * @param string|int $id Quote ID.
     *
     * @return Quote
     * @throws EntityNotFoundException
     * @throws MySqlException
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        /** @var Quote $quote */
        $quote = $this->getORM()->findById('Quote', $id, "quote_delete = 0");
        if ($quote === null) return null;
        $quote->client = $this->getORM()->findById('Client', $quote->client, "client_delete = 0");
        $quote->status = $this->getORM()->findById('QuoteStatus', $quote->status, "quote_status_delete = 0");
        $quote->products = [];
        $query = new Query("SELECT * FROM quote_products WHERE quote_product_quote = :id", [":id" => $quote->id]);
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess())
        {
            return $quote;
        }
        /** @var Products $products */
        $products = $this->loadModel('Products');
        foreach ($query->getResultSet() as $productData)
        {
            $quoteProduct = new QuoteProduct();
            $quoteProduct->fromArray($productData, "quote_product_");
            $quoteProduct->product = $products->getById($quoteProduct->product);
            $quote->products[] = $quoteProduct;
        }
        return $quote;
    }

    /**
     * Get number of quotes in the system.
     *
     * @return int
     *
     * @throws MySqlException
     */
    public function count()
    {
        $query = new Query('SELECT COUNT(quote_id) AS counter FROM quotes WHERE quote_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    /**
     * Get all quotes in the system.
     *
     * @return Quote[]|null
     *
     * @throws EntityNotFoundException
     */
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
     * Get all sent or draft quotes.
     *
     * @return Quote[]
     * @throws EntityNotFoundException
     */
    public function getAllSentOrDraft()
    {
        /** @var Quote[] $quotes */
        $quotes = $this->getORM()->find('Quote', "quote_status IN (1,2) AND quote_delete = 0");
        foreach ($quotes as $key => $quote)
        {
            $quotes[$key] = $this->getById($quote->id);
        }
        return $quotes;
    }

    /**
     * Get all invoiced quotes.
     *
     * @return Quote[]
     *
     * @throws EntityNotFoundException
     */
    public function getAllInvoiced()
    {
        /** @var Quote[] $quotes */
        $quotes = $this->getORM()->find('Quote', "quote_status = 5 AND quote_delete = 0");
        foreach ($quotes as $key => $quote)
        {
            $quotes[$key] = $this->getById($quote->id);
        }
        return $quotes;
    }

    /**
     * Update expired status for quotes.
     *
     * @return bool
     *
     * @throws MySqlException
     */
    public function updateExpired()
    {
        $query = new Query("UPDATE quotes SET quote_status = 6 WHERE quote_expire < NOW()");
        return $this->getMysql()->executeQuery($query)->isSuccess();
    }

    /**
     * Get quotes by months.
     *
     * Returns array with 1-12 cells, where the cell content is the number
     * of quote in the corresponding month.
     *
     * @return array
     *
     * @throws MySqlException
     */
    public function getQuotesByMonth()
    {
        $query = new Query('SELECT MONTH(quote_date) AS m, COUNT(quote_id) AS c FROM quotes WHERE quote_delete = 0 AND YEAR(quote_date) = :y GROUP BY MONTH(quote_date)', [':y' => date('Y')]);
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) {
            $result = [];
            for ($i = 1; $i <= 12; $i++) {
                $result[$i] = 0;
            }
            return $result;
        }
        $result = [];
        foreach ($query->getResultSet() as $row) {
            $result[$row['m']] = $row['c'];
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($result[$i]))
                $result[$i] = 0;
        }
        return $result;
    }

    /**
     * Get all quote statuses.
     *
     * @return QuoteStatus[]
     *
     * @throws EntityNotFoundException
     */
    public function getAllStatuses()
    {
        return $this->getORM()->find("QuoteStatus", "quote_status_delete = 0");
    }

    /**
     * Get quotes that match the search.
     *
     * @param string $term Search term (WHERE condition).
     * @param array $values Term parameters values.
     *
     * @return Quote[]|null
     * @throws EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search quotes values mush be an array");
        }
        $quotes = $this->getORM()->find('Quote',"$term AND quote_delete = 0", $values);
        /**
         * @var  $key
         * @var Quote $quote
         */
        foreach ($quotes as $key => $quote)
        {
            $quotes[$key] = $this->getById($quote->id);
        }
        return $quotes;
    }

    /**
     * Add quote to the system.
     *
     * @param Quote $quote
     *
     * @return Result
     */
    public function add($quote)
    {
        return $this->getORM()->save($quote);
    }

    /**
     * Delete quote from the system.
     *
     * @param Quote $quote
     *
     * @return Result
     */
    public function delete($quote)
    {
        $quote->delete = 1;
        return $this->getMysql()->executeQuery(new Query("UPDATE " . $quote->getTable() . " SET quote_delete = 1 WHERE quote_id = ?", [$quote->id]));
    }

}