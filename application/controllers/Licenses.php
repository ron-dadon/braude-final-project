<?php

namespace Application\Controllers;

use Application\Entities\License;
use Application\Models\Clients;
use Application\Models\Products;
use Application\Models\Invoices;
use Application\Models\Licenses as LicensesModel;
use Application\Models\LicenseTypes;
use Trident\Database\Result;

/**
 * Class Licenses
 *
 * This class provides the logic layer for the licenses data.
 *
 * @package Application\Controllers
 */
class Licenses extends IacsBaseController
{

    /**
     * Show all licenses.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Index()
    {
       /** @var LicensesModel $licenses */
        $licenses = $this->loadModel('Licenses');
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $viewData['licenses'] = $licenses->getAll();
        $this->getView($viewData)->render();
    }

    /**
     * Show license extended information.
     *
     * @param string|int $id License ID.
     *
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Show($id)
    {
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        /** @var LicensesModel $licenses */
        $licenses = $this->loadModel('Licenses');
        $viewData['license'] = $licenses->getById($id);
        $this->getView($viewData)->render();
    }

    /**
     * Add a new license.
     * License information must be passed via POST.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Add()
    {
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel('LicenseTypes');
        /** @var Clients $clients */
        $clients = $this->loadModel('Clients');
        /** @var Products $products*/
        $products = $this->loadModel('Products');
        /** @var Invoices $invoices*/
        $invoices = $this->loadModel('Invoices');
        $license = new License();
        if ($this->getRequest()->isPost())
        {
            /** @var LicensesModel $licenses */
            $licenses = $this->loadModel('Licenses');
            try{
                $file = $this->getRequest()->getFiles()->item('request_file');
            } catch (\InvalidArgumentException $e) {
                $file = null;
            }
            if ($file !== null) {
                if ($file->getError() == UPLOAD_ERR_OK) {
                    $product = $products->getById($this->getRequest()->getPost()->item('license_product'));
                    $client = $clients->getById($this->getRequest()->getPost()->item('license_client'));
                    $invoice = $invoices->getById($this->getRequest()->getPost()->item('license_invoice'));
                    $result = $licenses->fromRequest(
                        $file->getTemporaryName(), $this->getRequest()->getPost()->item('license_serial'),
                        $product, $client, $this->getRequest()->getPost()->item('license_expire'), $invoice);
                    if ($result instanceof Result) {
                        if ($result->isSuccess()) {
                            $this->addLogEntry('Created license ' . $result->getLastId() . ' successfully', 'success');
                            $this->setSessionAlertMessage("Created license successfully");
                            $this->redirect('/Licenses/Show/' . $result->getLastId());
                        } else {
                            $this->addLogEntry('Creating license from request failed. ' . $result->getErrorString());
                            $this->setSessionAlertMessage("Can't create license from request", "error");
                            $this->redirect('/Licenses/New');
                        }
                    } else {
                        $this->addLogEntry('Creating license from request failed. ' . $result);
                        $this->setSessionAlertMessage("Can't create license. Request file error {$result}", "error");
                        $this->redirect('/Licenses/New');
                    }
                } else if ($file->getError() != UPLOAD_ERR_NO_FILE) {
                    $this->addLogEntry('Creating license failed. Error uploading request file ' . $file->getName());
                    $this->setSessionAlertMessage("Can't create license. Request file upload error.", "error");
                    $this->redirect('/Licenses/New');
                }
            }
            $data = $this->getRequest()->getPost()->toArray();
            $license->fromArray($data, "license_");
            if ($license->isValid())
            {
                if ($license->invoice == 0) $license->invoice = null;
                $result = $this->getORM()->save($license);
                if ($result->isSuccess())
                {
                    $license->id = $result->getLastId();
                    $this->addLogEntry("Created license with ID: " . $license->id, "success");
                    $this->setSessionAlertMessage("Created license successfully");
                    $this->redirect('/Licenses/Show/' . $result->getLastId());
                }
                else
                {
                    $viewData['error'] = "Error adding license to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error adding license to database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to create a new license", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error adding license";
                $this->addLogEntry("Failed to create a new license - invalid data", "danger");
            }
        }
        $viewData['license'] = $license;
        $viewData['license-types'] = $licenseTypes->getAll();
        $viewData['clients'] = $clients->getAll();
        $viewData['products'] = $products->search("product_type = 'software'", []);
        if (($message = $this->pullSessionAlertMessage()) !== null)
        {
            $viewData[$message['type']] = $message['message'];
        }
        $this->getView($viewData)->render();
    }

    /**
     * Delete a license.
     * License ID for delete must be passed via POST delete_id.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Delete()
    {
        if ($this->getRequest()->isPost())
        {
            /** @var LicensesModel $licenses */
            $licenses = $this->loadModel('Licenses');
            try
            {
                $id = $this->getRequest()->getPost()->item('delete_id');
                /** @var License $license */
                $license = $licenses->getById($id);
                if ($license === null)
                {
                    $this->addLogEntry("Failed to delete license - supplied ID is invalid", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to license show
                    }
                }
                $result = $licenses->delete($license);
                if ($result->isSuccess())
                {
                    $this->addLogEntry("License with ID " . $id . " delete successfully", "success");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(true, ['license' => $license->serial]);
                    }
                    else
                    {
                        // Go to license list
                    }
                }
                else
                {
                    $this->getLog()->newEntry("Failed to delete license with ID " . $id . ": " . $result->getErrorString(), "database");
                    $this->addLogEntry("Failed to delete license from the database. Check the errors log for further information, or contact your system administrator.", "danger");
                    if ($this->getRequest()->isAjax())
                    {
                        $this->jsonResponse(false);
                    }
                    else
                    {
                        // Go to license show
                    }
                }
            }
            catch (\InvalidArgumentException $e)
            {
                $this->addLogEntry("Failed to delete license - no ID supplied", "danger");
                if ($this->getRequest()->isAjax())
                {
                    $this->jsonResponse(false);
                }
                else
                {
                    // Go to license show
                }
            }
        }
        $this->getView()->render();
    }

    /**
     * Update license information.
     * License updated information must be passed via POST.
     *
     * @param string|int $id License ID.
     *
     * @throws \Trident\Exceptions\IOException
     * @throws \Trident\Exceptions\ModelNotFoundException
     */
    public function Update($id)
    {
        /** @var LicensesModel $licenses */
        $licenses = $this->loadModel('Licenses');
        /** @var License $license */
        $license = $licenses->getById($id);
        if ($license === null)
        {
            $this->setSessionAlertMessage("Can't update license with ID {$id}. License doesn't exists");
            $this->redirect("/Licenses");
        }
        if ($this->getRequest()->isPost())
        {
            $expire = $this->getRequest()->getPost()->item('license_expire');
            $license->expire = $expire;
            $license->client = $license->client->id;
            $license->product = $license->product->id;
            $license->type = $license->type->id;
            $license->invoice = $license->invoice == null ? 0 : $license->invoice->id;
            if ($license->isValid())
            {
                if ($license->invoice == 0) $license->invoice = null;
                $result = $this->getORM()->save($license);
                if ($result->isSuccess())
                {
                    $license->id = $result->getLastId();
                    $this->addLogEntry("Updated license with ID: " . $license->id, "success");
                    $this->setSessionAlertMessage("License updated!");
                    $this->redirect('/Licenses/Show/' . $id);
                }
                else
                {
                    $viewData['error'] = "Error updating license to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating license in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update license", "danger");
                }
            }
            else
            {
                $viewData['error'] = "Error updating license";
                $this->addLogEntry("Failed to update license - invalid data", "danger");
            }
        }
        $viewData['license'] = $license;
        $this->getView($viewData)->render();
    }

    public function download($id)
    {
        /** @var LicensesModel $licenses */
        $licenses = $this->loadModel('Licenses');
        /** @var License $license */
        $license = $licenses->getById($id);
        if ($license === null)
        {
            $this->setSessionAlertMessage("Can't download license with ID {$id}. License doesn't exists");
            $this->redirect("/Licenses");
        }
        ob_clean();
        header('Content-Type: application/xml');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $license->client->name . ' - ' . $license->product->name . ' - ' . $license->serial . '.iacslic' . "\"");
        echo $license->toFile();
        exit();
    }

}