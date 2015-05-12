<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;

class Error extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
    <div class="container-fluid">
        <h1 class="bg-danger"><i class="fa fa-fw fa-exclamation"></i> Error</h1>
        <div class="alert alert-danger">
            <h1>Error!</h1>
            <p>An error occurred.</p>
        </div>
    </div>
<?php
        $this->getSharedView('Footer')->render();
    }

} 