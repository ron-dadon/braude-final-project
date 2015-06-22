<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;

/**
 * Class Index
 *
 * Show administration index.
 *
 * @package Application\Views\Administration
 */
class Index extends AbstractView
{

    /**
     * Render administration index.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-cog"></i> Administration</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-4">
            <a href="<?php $this->publicPath() ?>Administration/Settings" class="btn btn-block btn-default btn-big">
                <h1><i class="fa fa-fw fa-cogs"></i></h1>
                <h2>Settings</h2>
            </a>
        </div>
        <div class="col-xs-12 col-lg-4">
            <a href="<?php $this->publicPath() ?>Administration/Users" class="btn btn-block btn-default btn-big">
                <h1><i class="fa fa-fw fa-users"></i></h1>
                <h2>Users</h2>
            </a>
        </div>
        <div class="col-xs-12 col-lg-4">
            <a href="<?php $this->publicPath() ?>Administration/Log" class="btn btn-block btn-default btn-big">
                <h1><i class="fa fa-fw fa-th-list"></i></h1>
                <h2>Log</h2>
            </a>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}