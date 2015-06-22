<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Models;

use Trident\Database\Result;
use Trident\MVC\AbstractModel;
use Application\Entities\LicenseType;
use Trident\Exceptions\EntityNotFoundException;

/**
 * Class LicenseTypes
 *
 * This class provides the data-access layer to the license types in the database.
 *
 * @package Application\Models
 */
class LicenseTypes extends AbstractModel
{

    /**
     * Get license type by it's ID.
     *
     * @param string|int $id License type ID.
     *
     * @return LicenseType|null
     * @throws EntityNotFoundException
     */
    public function getById($id)
    {
        if ($id === null) return null;
        return $this->getORM()->findById('LicenseType', $id, "license_type_delete = 0");
    }

    /**
     * Get all license types.
     *
     * @return LicenseType[]|null
     * @throws EntityNotFoundException
     */
    public function getAll()
    {
        return $this->getORM()->find('LicenseType', "license_type_delete = 0");
    }

    /**
     * Add new license type to the system.
     *
     * @param LicenseType $licenseType
     *
     * @return Result
     */
    public function add($licenseType)
    {
        return $this->getORM()->save($licenseType);
    }

    /**
     * Delete license type from the system.
     *
     * @param LicenseType $licenseType
     *
     * @return Result
     */
    public function delete($licenseType)
    {
        $licenseType->delete = 1;
        return $this->getORM()->save($licenseType);

    }

} 