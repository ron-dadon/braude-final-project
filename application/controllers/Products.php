<?php

namespace Application\Controllers;

use Application\Entities\Product;
use Application\Models\Products as ProductsModel;
use Trident\Database\Query;

class Products extends IacsBaseController
{

    public function Index()
    {
        /** @var ProductsModel $products */
        $products = $this->loadModel('Products');
        $list = $products->getAll();
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $viewData['products'] = $list;
        $this->getView($viewData)->render();
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
                        $this->redirect("/Products");
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
                        $this->setSessionAlertMessage("Product " . $product->name . " deleted successfully.");
                        $this->redirect("/Products");                    }
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
                        $this->redirect("/Products");
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
                    $this->redirect("/Products");
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
            $this->setSessionAlertMessage("Can't edit Product with ID $id. Product was not found.", "error");
            $this->redirect("/Products");
        }
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $product->fromArray($data, "product_");
            if ($product->isValid())
            {
                $result = $this->getORM()->save($product);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("Updated product with ID: " . $product->id, "success");
                    $this->setSessionAlertMessage("Product {$product->name} updated.", "success");
                }
                else
                {
                    $viewData['error'] = "Error updating product to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating product in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update product", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error updating product";
                $this->addLogEntry("Failed to update product - invalid data", "danger");
            }
        }
        $viewData['product'] = $product;
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

}