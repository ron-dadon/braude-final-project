<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Error;

use \Trident\MVC\AbstractView;

/**
 * Class Index
 *
 * Show general error message.
 *
 * @package Application\Views\Error
 */
class Index extends AbstractView
{

    /**
     * Render general error message.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-error">
        <h1><i class="fa fa-fw fa-exclamation-circle"></i> Error</h1>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div class="media">
                <div class="media-object media-left">
                    <i class="fa fa-fw fa-4x fa-exclamation-circle"></i>
                </div>
                <div class="media-body media-right">
                    <h3 class="margin-bottom">Oops! Something went wrong!</h3>
                    <p>For further information please check the errors log, or contact your system administrator.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

} 