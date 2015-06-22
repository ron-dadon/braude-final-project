<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\Product;
use Trident\Database\Query;
use Trident\Database\Result;
use Trident\Exceptions\EntityNotFoundException;
use Trident\Exceptions\MySqlException;

/**
 * Class Products
 *
 * This class provides the data-access layer to the products in the database.
 *
 * @package Application\Models
 */
class Products extends AbstractModel
{

    /**
     * Get product by it's ID.
     * @param string|int $id Product ID.
     *
     * @return Product|null
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        /** @var Product $product */
        $product = $this->getORM()->findById('Product', $id,"product_delete = 0");
        $product->license = $this->getORM()->findById('LicenseType', $product->license, "license_type_delete = 0");
        return $product;
    }

    /**
     * Get the number of products in the system.
     *
     * @return int
     * @throws MySqlException
     */
    public function count()
    {
        $query = new Query('SELECT COUNT(product_id) AS counter FROM products WHERE product_delete = 0');
        $query = $this->getMysql()->executeQuery($query);
        if (!$query->isSuccess()) return 0;
        return $query->getResultSet()[0]['counter'];
    }

    /**
     * Get all the products in the system.
     *
     * @return Product[]|null
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        $list = $this->getORM()->find('Product', "product_delete = 0");
        foreach ($list as $k => $v) {
            /** @var Product $v */
            $list[$k] = $this->getById($v->id);
        }
        return $list;
    }

    /**
     * Get products that match the search.
     *
     * @param string $term Search term (WHERE condition).
     * @param array $values Term parameters values.
     *
     * @return Product[]|null
     * @throws EntityNotFoundException
     */
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
     * Add product to the system.
     *
     * @param Product $product
     *
     * @return Result
     */
    public function add($product)
    {
        return $this->getORM()->save($product);
    }

    /**
     * Delete product from the system.
     *
     * @param Product $product
     *
     * @return Result
     */
    public function delete($product)
    {
        $product->delete = 1;
        return $this->getORM()->save($product);

    }

} 