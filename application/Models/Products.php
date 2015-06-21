<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Product;
use Trident\Database\Query;

class Products extends AbstractModel
{

    public function getById($id)
    {
        /** @var Product $product */
        $product = $this->getORM()->findById('Product', $id,"product_delete = 0");
        $product->license = $this->getORM()->findById('LicenseType', $product->license, "license_type_delete = 0");
        return $product;
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
        $list = $this->getORM()->find('Product', "product_delete = 0");
        foreach ($list as $k => $v) {
            /** @var Product $v */
            $list[$k] = $this->getById($v->id);
        }
        return $list;
    }

    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search products values mush be an array");
        }
        $list = $this->getORM()->find('Product',"$term AND product_delete = 0", $values);
        foreach ($list as $k => $v) {
            /** @var Product $v */
            $list[$k] = $this->getById($v->id);
        }
        return $list;
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