<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Product;

class Products extends AbstractModel
{
    /**add non deleted find**/
    public function getById($id)
    {
        return $this->getORM()->findById('Product', $id);
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