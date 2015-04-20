<?php
/**
 * Created by PhpStorm.
 * User: רון
 * Date: 20/04/2015
 * Time: 15:44
 */

abstract class IACS_View extends Trident_Abstract_View
{

    /**
     * Logged user.
     *
     * @var User_Entity
     */
    protected $user;

    function __construct($configuration, $data)
    {
        parent::__construct($configuration, $data);
        $this->user = $this->get('user');
    }

}