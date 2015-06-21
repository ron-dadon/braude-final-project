<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\LicenseType;

class LicenseTypes extends AbstractModel
{

    public function getById($id)
    {
        if ($id === null) return null;
        return $this->getORM()->findById('LicenseType', $id, "license_type_delete = 0");
    }

    public function getAll()
    {
        return $this->getORM()->find('LicenseType', "license_type_delete = 0");
    }

    /**
     * @param LicenseType $licenseType
     *
     * @return \Trident\Database\Result
     */
    public function add($licenseType)
    {
        return $this->getORM()->save($licenseType);
    }
    /**
     * @param LicenseType $licenseType
     *
     * @return \Trident\Database\Result
     */
    public function delete($licenseType)
    {
        $licenseType->delete = 1;
        return $this->getORM()->save($licenseType);

    }

} 