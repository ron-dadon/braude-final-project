<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Product;
use Trident\Database\Query;

class Products extends AbstractModel
{

    public function getById($id)
    {
        return $this->getORM()->findById('Product', $id,"product_delete = 0");
    }

    public function count()
    {
        $query = new Query('SELECT COUNT(product_id) AS counter FROM products WHERE product_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    public function getAll()
    {
        return $this->getORM()->find('Product', "product_delete = 0");
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search products values mush be an array");
        }
        return $this->getORM()->find('Product',"$term AND product_delete = 0", $values);
    }

    /**
     * @param Product $product
     *
     * @return \Trident\Database\Result
     */
    public function add($product)
    {
        return $this->getORM()->save($product);
    }
    /**
     * @param Product $product
     *
     * @return \Trident\Database\Result
     */
    public function delete($product)
    {
        $product->delete = 1;
        return $this->getORM()->save($product);

    }
} 