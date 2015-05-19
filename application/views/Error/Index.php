<?php

namespace Application\Views\Error;

use \Trident\MVC\AbstractView;

class Index extends AbstractView
{

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