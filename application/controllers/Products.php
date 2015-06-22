<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Controllers;

use Application\Entities\Product;
use Application\Models\LicenseTypes;
use Application\Models\Products as ProductsModel;
use Trident\Database\Query;

/**
 * Class Products
 *
 * This class provides the logic layer for the products data.
 *
 * @package Application\Controllers
 */
class Products extends IacsBaseController
{

    /**
     * Show all products.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
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

    /**
     * Show extended product information.
     *
     * @param string|int $id Product ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function show($id)
    {
        /** @var ProductsModel $products */
        $products = $this->loadModel('Products');
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel("LicenseTypes");
        /** @var Product $product */
        $product = $products->getById($id);
        $product->license = $licenseTypes->getById($product->license);
        if ($product === null)
        {
            $this->setSessionAlertMessage("Can't show product with ID $id. Product was not found.", "error");
            $this->redirect("/Products");
        }
        $viewData['product'] = $product;
        $this->getView($viewData)->render();
    }

    /**
     * Add a new product.
     * Product information must be passed via POST.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Add()
    {
        $product = new Product();
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel('LicenseTypes');
        $viewData['license-types'] = $licenseTypes->getAll();
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
                    $this->setSessionAlertMessage("Product {$product->name} added!", "success");
                    $this->redirect("/Products");
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

    /**
     * Delete a product.
     * Product ID for delete must be passed via POST delete_id.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var ProductsModel $products */
            $products = $this->loadModel('Products');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                /** @var Product $product */
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
                        $this->redirect("/Products");
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

    /**
     * Update a product.
     * Product updated information must be passed via POST.
     *
     * @param string|int $id Product ID.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Update($id)
    {
        /** @var ProductsModel $products */
        $products = $this->loadModel('Products');
        /** @var Product $product */
        $product = $products->getById($id);
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel('LicenseTypes');
        $product->license = $licenseTypes->getById($product->license);
        $viewData['license-types'] = $licenseTypes->getAll();
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
                    $this->redirect("/Products/Update/{$product->id}");
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

    /**
     * Get all products as a JSON object for AJAX request.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function ajaxGetAll()
    {
        if (!$this->getRequest()->isAjax()) die();
        /** @var ProductsModel $products */
        $products = $this->loadModel('Products');
        $list = $products->getAll();
        echo json_encode($list, JSON_UNESCAPED_UNICODE);
        exit;
    }
}