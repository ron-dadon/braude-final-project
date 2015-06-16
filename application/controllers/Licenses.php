<?php

namespace Application\Controllers;

use Application\Entities\License;
use Application\Models\Clients;
use Application\Models\Licenses as LicensesModel;
use Application\Models\LicenseTypes;
class Licenses extends IacsBaseController
{

    public function Index()
    {
        $this->getView()->render();
    }

    public function Add()
    {
        /** @var LicenseTypes $licenseTypes */
        $licenseTypes = $this->loadModel('LicenseTypes');
        /** @var Clients $clients */
        $clients= $this->loadModel('Clients');
        $license = new License();
        if ($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $license->fromArray($data, "license_");
            if ($license->isValid())
            {
                $result = $this->getORM()->save($license);
                if ($result->isSuccess())
                {
                    $license->id = $result->getLastId();
                    $this->addLogEntry("Created license with ID: " . $license->id, "success");
                    // Add go to show license
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
        $viewData['license-types']= $licenseTypes->getAll();
        $viewData['client']= $clients->getAll();
        $this->getView($viewData)->render();
    }

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

    public function Update($id)
    {
        /** @var LicensesModel $licenses */
        $licenses = $this->loadModel('Licenses');
        /** @var License $license */
        $license = $licenses->getById($id);
        if ($license === null)
        {
            $this->redirect("/Licenses");
        }
        if ($this->getRequest()->isAjax())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $license->fromArray($data, "license_");
            if ($license->isValid())
            {
                $result = $this->getORM()->save($license);
                if ($result->isSuccess())
                {
                    $license->id = $result->getLastId();
                    $this->addLogEntry("Updated license with ID: " . $license->id, "success");
                    $this->jsonResponse(true);
                }
                else
                {
                    $viewData['error'] = "Error updating license to the database. Check the errors log for further information, or contact your system administrator.";
                    $this->getLog()->newEntry("Error updating license in the database: " . $result->getErrorString(), "Database");
                    $this->addLogEntry("Failed to update license", "danger");
                    $this->jsonResponse(false);
                }
            }
            else
            {
                $viewData['error'] = "Error updating license";
                $this->addLogEntry("Failed to update license - invalid data", "danger");
                $this->jsonResponse(false);
            }
        }
        $viewData['license'] = $license;
        $this->getView($viewData)->render();
    }

}