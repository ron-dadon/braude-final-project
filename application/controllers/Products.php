<?php

namespace Application\Controllers;

use Application\Entities\Product;
use Application\Models\Products as ProductsModel;

class Products extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

    public function Add()
    {
        $product = new Product();
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $product->fromArray($data, "product_");
            if ($product->isValid())
            {
                $result = $this->getORM()->save($product);
                if ($result->isSuccess())
                {
                    $product->id = $result->getLastId();
                    $this->addLogEntry("Created product with ID: " . $product->id, "success");
                    // Add go to show product
                }
                else
                {
                    $viewData['error'] = "Error adding product to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding product to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new product", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error adding product";
                $this->addLogEntry("Failed to create a new product - invalid data", "danger");
            }
        }
        $viewData['product'] = $product;
        $this->getView($viewData)->render();
    }

    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var ProductsModel $products */
            $products = $this->loadModel('Products');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                $product = $products->getById($id);
                if ($product === null)
                {
                    $this->addLogEntry("Failed to delete product - supplied ID is invalid", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to product show
                    }
                }
                $result = $products->delete($product);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Product with ID " . $id . " delete successfully", "success");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(true, ['product' => $product->name]);
                    }
                    else
                    {
                        // Go to product list
                    }
                }
                else
                {
                    $this->getLog()->newEntry("Failed to delete product with ID " . $id . ": " . $result->getErrorString(), "database");
                    $this->addLogEntry("Failed to delete product from the database. Check the errors log for further information, or contact your system administrator.", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to product show
                    }
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->addLogEntry("Failed to delete product - no ID supplied", "danger");
                if ($this->getRequest()->isAjax())
                {
                    $this->jsonResponse(false);
                }
                else
                {
                    // Go to product show
                }
            }
        }
        $this->getView()->render();
    }

    public function Update($id)
    {
        /** @var ProductsModel $products */
        $products = $this->loadModel('Products');
        $product = $products->getById($id);
        if ($product === null)
        {
            $this->redirect("/Products");
        }
        if ($this->getRequest()->isAjax())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $product->fromArray($data, "product_");
            if ($product->isValid())
            {
                $result = $this->getORM()->save($product);
                if ($result->isSuccess())
                {
                    $product->id = $result->getLastId();
                    $this->addLogEntry("Updated product with ID: " . $product->id, "success");
                    $this->jsonResponse(true);
                }
                else
                {
                    $viewData['error'] = "Error updating product to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating product in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update product", "danger");
                    $this->jsonResponse(false);
                }
            }
            else
            {
                $viewData['error'] = "Error updating product";
                $this->addLogEntry("Failed to update product - invalid data", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['product'] = $product;
        $this->getView($viewData)->render();
    }

}