<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;

class Index extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <h1 class="text-left"><i class="fa fa-fw fa-home"></i>Home</h1>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}