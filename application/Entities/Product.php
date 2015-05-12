<?php
/**
 * Created by PhpStorm.
 * User: פרנקו
 * Date: 12/05/2015
 * Time: 14:39
 */

namespace application\Entities;


use Trident\ORM\Entity;

class Product extends Entity {
    public $id;
    public $name;
    public $description;
    public $basePrice;
    public $type;
    /**software*/
    public $version;
    public $license;
    /**training*/
    public $length;
    public $units;

    /**
     * Implement validation rules.
     * Return true if valid, or false otherwise.
     * Set validation errors to the errors array.
     *
     * @return bool True if valid, false otherwise.
     */
    public function isValid()
    {
        // TODO: Implement isValid() method.
    }


} 