<?php

namespace Application\Models;

use Trident\MVC\AbstractModel;
use Application\Entities\License;

class Licenses extends AbstractModel
{

    /**
     * @param $id
     *
     * @return License
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getById($id)
    {
        /** @var License $license */
        $license = $this->getORM()->findById('License', $id, "license_delete = 0");
        $license->client = $this->getORM()->findById('Client', $license->client, 'client_delete = 0');
        $license->type = $this->getORM()->findById('LicenseType', $license->type, 'license_type_delete = 0');
        $license->product = $this->getORM()->findById('Product', $license->product, 'product_delete = 0');
        if ($license->invoice !== null) {
            $license->invoice = $this->getORM()->findById('Invoice', $license->invoice, 'invoice_delete = 0');
        }
        return $license;
    }

    /**
     * @return \Application\Entities\License[]
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function getAll()
    {
        /** @var License[] $licenses */
        $licenses = $this->getORM()->find('License', "license_delete = 0");
        foreach ($licenses as $key => $value) {
            $licenses[$key] = $this->getById($value->id);
        }
        return $licenses;
    }

    /**
     * @param $term
     * @param $values
     *
     * @return \Application\Entities\License[]
     * @throws \Trident\Exceptions\EntityNotFoundException
     */
    public function search($term, $values)
    {
        if (!is_array($values))
        {
            throw new \InvalidArgumentException("Search license values mush be an array");
        }
        /** @var License[] $licenses */
        $licenses = $this->getORM()->find('License',"$term AND license_delete = 0", $values);
        foreach ($licenses as $key => $value) {
            $licenses[$key] = $this->getById($value->id);
        }
        return $licenses;
    }

    /**
     * @param License $license
     *
     * @return \Trident\Database\Result
     */
    public function add($license)
    {
        return $this->getORM()->save($license);
    }
    /**
     * @param License $license
     *
     * @return \Trident\Database\Result
     */
    public function delete($license)
    {
        $license->delete = 1;
        return $this->getORM()->save($license);

    }
} 